<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETU Bank</title>
    <link rel="stylesheet" href="mainMenu.css">
    <?php require('head.html') ?>
</head>

<body>
    <?php require($_SERVER["DOCUMENT_ROOT"] . '/sideMenu.html'); ?>
    <main id="dashboard">
        <h1 id="dashboard-heading">Dashboard</h1>
        <section class="dashboard top-row">
            <div class="card customers">
                <div class="card-content">
                    <h4>Total Customers</h4>
                    <span class="customers count"></span>
                </div>
                <div class="card-icon customer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z" />
                    </svg>
                </div>
            </div>
            <div class="card deposit-accounts">
                <div class="card-content">
                    <h4>Total Deposit Accounts</h4>
                    <span class="deposit-accounts count"></span>
                </div>
                <div class="card-icon deposit-accounts">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M19.83 7.5L17.56 5.23C17.63 4.81 17.74 4.42 17.88 4.08C17.96 3.9 18 3.71 18 3.5C18 2.67 17.33 2 16.5 2C14.86 2 13.41 2.79 12.5 4H7.5C4.46 4 2 6.46 2 9.5S4.5 21 4.5 21H10V19H12V21H17.5L19.18 15.41L22 14.47V7.5H19.83M13 9H8V7H13V9M16 11C15.45 11 15 10.55 15 10S15.45 9 16 9C16.55 9 17 9.45 17 10S16.55 11 16 11Z" />
                    </svg>
                </div>
            </div>
            <div class="card current-accounts">
                <div class="card-content">
                    <h4>Total Current Accounts</h4>
                    <span class="current-accounts count"></span>
                </div>
                <div class="card-icon current-accounts">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M3,6H21V18H3V6M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M7,8A2,2 0 0,1 5,10V14A2,2 0 0,1 7,16H17A2,2 0 0,1 19,14V10A2,2 0 0,1 17,8H7Z" />
                    </svg>
                </div>
            </div>
            <div class="card loan-accounts">
                <div class="card-content">
                    <h4>Total Loan Accounts</h4>
                    <span class="loan-accounts count"></span>
                </div>
                <div class="card-icon loan-accounts">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 4H4A2 2 0 0 0 2 6V18A2 2 0 0 0 4 20H20A2 2 0 0 0 22 18V6A2 2 0 0 0 20 4M20 11H4V8H20Z" />
                    </svg>
                </div>
            </div>
        </section>
        <section class="dashboard middle-row">
            <div class="card panel span-8">
                <div class="panel-head">
                    <h3>Deposits vs Withdrawals (12 mo)</h3>
                </div>
                <div class="canvas-container">
                    <canvas id="chart-flows" height="140"></canvas>
                </div>
            </div>
            <div class="card panel span-4">
                <div class="panel-head">
                    <h3>Account Type Distribution</h3>
                </div>
                <div class="canvas-container">
                    <canvas id="chart-accounts" height="180"></canvas>
                </div>
            </div>
        </section>
        <section class="dashboard bottom-row">
            <div class="transactions-table">
                <div class="transactions-header">
                    <h4>Recent Transactions</h4>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Account</th>
                            <th>Type</th>
                            <th class="right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="action-buttons">
                <button class="action-button add">Add Customer</button>
                <button class="action-button lodge">Deposit money</button>
                <button class="action-button withdraw">Withdraw money</button>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="./dashboard.js"></script>
</body>

</html>