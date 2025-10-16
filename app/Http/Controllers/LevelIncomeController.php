<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserDetails;
use App\LevelDetails;
use App\ProfileStore;
use App\LevelIncome;
use Log;

class LevelIncomeController extends Controller
{
        public function checkStarQualification($userId)
    {
        try {
            $user = UserDetails::where('userid', $userId)->first();
            if (!$user) {
                Log::warning("STAR Check: User not found for ID $userId");
                return 0;
            }

            $starLevels = LevelDetails::where('status', 2)->get();
            $directs    = $user->total_direct;
            $teamA      = $user->current_investment;
            $weakerTeam = $user->total_investment - $teamA;
            $selfId     = $user->current_self_investment;

            foreach ([4,3,2,1] as $star) {
                $starReq = $starLevels->where('direct_count', $star)->first();
                if (!$starReq) continue;

                if ($selfId >= $starReq->self_id
                    && $teamA >= $starReq->team_a
                    && $weakerTeam >= $starReq->weaker_team
                    && $directs >= $starReq->direct_sponsor
                ) {
                    return $star;
                }
            }
            return 0;
        } catch (\Exception $e) {
            Log::error("STAR Check Error for UserID $userId: ".$e->getMessage());
            return 0;
        }
    }
  public function levelDistribution()
{
    Log::info("Level Distribution Cron Started");

    try {
        $allUsers = UserDetails::where('userstate', '>', 0)->get();
        Log::info("Total Active Users: ".count($allUsers));

        if (!$allUsers || count($allUsers) == 0) {
            Log::info("No active users to distribute.");
            return;
        }

        $profileStore = ProfileStore::where('id',1)->first();
        $capping = app()->make('App\Http\Controllers\StackingDetailController');

        foreach($allUsers as $user){
            try {
                $distributedCps = 0;
                $i = 1;
                $guiderId = $user->sponsorid;

                Log::info("Start distribution for UserID {$user->userid} | SponsorID: $guiderId");

                while($guiderId > 0 && $i <= 40){
                    try {
                        $guider = UserDetails::where('userid', $guiderId)->first();

                        if(!$guider) {
                            Log::warning("Guider not found for ID $guiderId");
                            break;
                        }

                        $guiderCps = ($guider->level_status==2 && $guider->leveluser >= $distributedCps)
                                        ? $guider->leveluser
                                        : $guider->levelStatus();

                        // DEBUG: Show guider details
                        Log::info("GuiderID: {$guider->userid}, guiderCps: $guiderCps, distributedCps: $distributedCps, level_status: {$guider->level_status}, capping: {$guider->capping}, permission: {$guider->user()->permission}");

                        // Get today's ROI
                        $roiAmount = $user->stackingIncome()
                            ->where('levelincome',1)
                            ->whereBetween('created_at',[date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
                            ->sum('amt_usdt');

                        Log::info("UserID {$user->userid} ROI today: $roiAmount");

                        if($roiAmount <= 0) {
                            Log::info("UserID {$user->userid} has no ROI today. Skipping to next user.");
                            break; // <-- ROI zero problem
                        }

                        // LEVEL 1-14
                        if($i <= 14){
                            if($distributedCps < $guiderCps && $guider->user()->permission==1 && $guider->capping!=1 && $guider->level_status!=0){
                                $level = $guiderCps - $distributedCps;
                                $levelAmount = $roiAmount * $level / 100;
                                $levAmount = $capping->cappingCalculation($guider->id, $levelAmount);

                                Log::info("Level $i: Calculated levelAmount: $levelAmount, after capping: $levAmount");

                                if($levAmount > 0){
                                    LevelIncome::create([
                                        'userid' => $guider->id,
                                        'fromuser' => $user->id,
                                        'amount' => $levAmount / $profileStore->price,
                                        'remaining' => $levAmount / $profileStore->price,
                                        'amt_usdt' => $levAmount,
                                        'txnid' => 0,
                                        'description' => 'l',
                                        'created_at' => now(),
                                    ]);
                                    Log::info("Level $i: Distributed $levAmount USDT to UserID {$guider->userid}");
                                    $distributedCps += $level;
                                }
                                $i++;
                            } else {
                                Log::info("Level $i conditions not met for GuiderID {$guider->userid}. Skipping.");
                                break;
                            }
                        }
                        // LEVEL 15+ STAR
                        else{
                            $starRank = $this->checkStarQualification($guider->userid);
                            Log::info("Level $i (STAR) check for GuiderID {$guider->userid}: STAR Rank = $starRank");

                            if($starRank >= 1){
                                if($distributedCps < $guiderCps && $guider->user()->permission==1 && $guider->capping!=1 && $guider->level_status!=0){
                                    $level = $guiderCps - $distributedCps;
                                    $levelAmount = $roiAmount * $level / 100;
                                    $levAmount = $capping->cappingCalculation($guider->id, $levelAmount);

                                    Log::info("Level $i (STAR): Calculated levelAmount: $levelAmount, after capping: $levAmount");

                                    if($levAmount > 0){
                                        LevelIncome::create([
                                            'userid' => $guider->id,
                                            'fromuser' => $user->id,
                                            'amount' => $levAmount / $profileStore->price,
                                            'remaining' => $levAmount / $profileStore->price,
                                            'amt_usdt' => $levAmount,
                                            'txnid' => 0,
                                            'description' => 'l',
                                            'created_at' => now(),
                                        ]);
                                        Log::info("Level $i (STAR): Distributed $levAmount USDT to UserID {$guider->userid}");
                                        $distributedCps += $level;
                                    }
                                    $i++;
                                } else {
                                    Log::info("Level $i (STAR) conditions not met for GuiderID {$guider->userid}. Skipping.");
                                    break;
                                }
                            } else {
                                Log::info("Level $i (STAR) not qualified for GuiderID {$guider->userid}. Stop distribution.");
                                break;
                            }
                        }

                        $guiderId = $guider->sponsorid;

                    } catch (\Exception $e) {
                        Log::error("Error processing guider $guiderId: ".$e->getMessage());
                        break;
                    }
                }

                Log::info("End distribution for UserID {$user->userid}");

            } catch (\Exception $e) {
                Log::error("Error processing user {$user->userid}: ".$e->getMessage());
            }
        }

    } catch (\Exception $e) {
        Log::error("Level Distribution Cron Failed: ".$e->getMessage());
    }

    Log::info("Level Distribution Cron Ended");
}
}
