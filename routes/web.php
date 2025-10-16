<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.dashboard');
});

Auth::routes();
// Wallet login route
Route::get('/wallet-login', [App\Http\Controllers\Auth\LoginController::class, 'username'])->name('wallet.login');
Route::post('/wallet-login', [App\Http\Controllers\Auth\LoginController::class, 'username']);

Route::get('get-sponsor/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'getSponsor']);
Route::get('/Transaction/transactionStatus/{id}','CpsIncomeController@paymentStatus');
Route::get('/home', 'HomeController@index')->name('home');




//User Routes

    Route::get('/User/Dashboard', 'HomeController@userindex');
    Route::get('/User/Documentation', 'HomeController@documentation');
    Route::get('/User/ArbitrageDashboard', 'HomeController@userarbitrageindex');

    Route::get('/User/EditProfile', 'UserDetailsController@showEditData');
    Route::post('/User/EditProfile', 'UserDetailsController@userUpdate');
    Route::get('/User/resendProfileOtp','AssetDetailChangesController@resendProfileEditOtpWeb');

    Route::get('/User/ChangePassword', 'UserDetailsController@showChangePass');
    Route::post('/User/ChangePassword', 'UserDetailsController@UserChangePass');

    Route::get('/User/DirectTeam', 'UserDetailsController@getDirect');
    Route::get('/User/AllTeam', 'UserDetailsController@getTotal');
    Route::get('/User/TeamSummary', 'UserDetailsController@userTeamSummary');
    Route::get('/User/Treeview', 'UserDetailsController@getTreeView');

    //New Registration
    Route::get('/User/NewRegistration', 'AssetDetailController@userNewRegistrationPage');
    Route::post('/User/NewRegistration', 'AssetDetailController@userNewRegistration');
    Route::get('/getSponsorNew/{sponsorid}','AssetDetailController@getSponsor');


    //Transaction using hash System
    /*Route::get('/User/BuyMWT', 'TransactionDetailController@showTransactionPage');
    Route::post('/User/BuyMWT', 'TransactionDetailController@submitTransaction');*/

    // Transaction using NP
    Route::get('/User/Deposit','CpsIncomeController@showPage');
    Route::post('/User/Deposit','CpsIncomeController@submitTransaction');

    // Deposit History
    Route::get('/User/DepositHistory', 'BonusRewardController@userDepositHistory');

    // Stack 
    Route::get('/User/Stake', 'WalletTransferController@stakePage');
    Route::post('/User/getUser', 'WalletTransferController@getUserDetail');
    Route::post('/User/Stake', 'WalletTransferController@stakeMWT');
    Route::get('/User/StakingHistory', 'BonusRewardController@userUpgradeHistory');
    Route::get('/User/StakingTxnHistory', 'BonusRewardController@userUpgradeTxnHistory');

    // loan 
    Route::get('/User/getUserLoan', 'LoanDetailsController@loanPage');
    Route::post('/User/GetLoan', 'LoanDetailsController@getLoan');
    Route::get('/User/RepayLoan', 'LoanDetailsController@loanRepaymentPage');
    Route::post('/User/RepayLoan', 'LoanDetailsController@loanRepayment');
    Route::get('/User/RepaymentHistory', 'LoanDetailsController@userRepaymentHistory');

    //Income
    Route::get('/User/IncomeOverview', 'BonusRewardController@userIncomeOverview');
    Route::post('/User/IncomeOverview', 'BonusRewardController@userIncomeOverview');
    
    Route::get('/User/StakingReward', 'BonusRewardController@userStakingReport');
    Route::post('/User/StakingReward', 'BonusRewardController@userStakingReport');
    Route::get('/User/DirectBonus', 'BonusRewardController@userDirectReport');
    Route::post('/User/DirectBonus', 'BonusRewardController@userDirectReport');
    Route::get('/User/StakingReferralReward', 'BonusRewardController@userStakingReferralReward');
    Route::post('/User/StakingReferralReward', 'BonusRewardController@userStakingReferralReward');
    Route::get('/User/StakingReferralReward/{txndate}', 'BonusRewardController@userStakingReferralRewardDate');
    Route::get('/User/TeamDevelopmentReward', 'BonusRewardController@userTeamDevelopmentReward');
    Route::post('/User/TeamDevelopmentReward', 'BonusRewardController@userTeamDevelopmentReward');
    Route::get('/User/TeamDevelopmentReward/{txndate}', 'BonusRewardController@userTeamDevelopmentRewardDate');
    Route::get('/User/ClubReward', 'BonusRewardController@userClubReward');
    Route::post('/User/ClubReward', 'BonusRewardController@userClubReward');
    Route::get('/User/LifetimeAchievementReward', 'BonusRewardController@userLifetimeReward');
    Route::post('/User/LifetimeAchievementReward', 'BonusRewardController@userLifetimeReward');

    //Withdraw
    Route::get('/User/WithdrawRequest', 'WithdrawInfoController@withdrawPage');
    Route::post('/User/WithdrawRequest', 'WithdrawInfoController@withdrawRequest');
    Route::get('/User/WithdrawalHistory', 'BonusRewardController@withdrawHistoryUser');
    Route::get('/User/resendWithdrawOtp','AssetDetailChangesController@resendWithdrawOtpWeb');

    Route::get('/User/WithdrawLifetimeReward', 'WithdrawInfoController@withdrawLifetimeIncome');

    //Support
    Route::post('/User/CreateTicket','SupportQueryController@UserCreateTicket');
    Route::get('/User/ViewTicket','SupportQueryController@viewUserTicket');
    Route::get('/User/TicketView/{title}/{id}','SupportQueryController@viewTicketSingleUser');
    Route::post('/User/ReplyTicket','SupportQueryController@postReplyUser');

