# ENTITIES:

<u>PRIMARY KEYS LISTED IN ALL CAPS</u>

## Customer details

- PK CUSTOMER NO
- password
- first name
- surname
- address
- eircode
- date of birth
- telephone no
- occupation
- salary
- email address
- guarantor's name (if applicable)
- deleted flag

## Staff

- PK STAFF ID
- staff password
- staff name
- role (manager, teller, etc.)

## Deposit account

- PK ACCOUNT ID
- account number (generated unique random number)
- FK customer no
- balance
- deleted flag

## Loan account

- PK ACCOUNT ID
- account number
- FK customer no
- balance
- loan amount
- loan start date
- loan term
- loan monthly repayments
- deleted flag

## Current account

- PK ACCOUNT ID
- account number
- FK customer no
- balance
- overdraft limit
- deleted flag

## Loan rate table

- PK ashdjk
- amount borrowed
- loan term (in months)
- rate
- rate
- rate
- rate

## Interest rate table

- current rate

## Quote deposit rate (report)

- current deposit rate for loans (XX.XX%)

## Quote loan rate (report)

- current interest rate for loans (XX.XX%)

## Quote current account rate (report)

- interest on credit balances (XX.XX%)
- interest on overdrawn balances (XX.XX%)

## Deposit account history

- PK TRANSACTION ID
- FK ACCOUNT ID
- date of transaction
- transaction type (withdrawal, lodgement, interest earned)
- transaction amount
- balance (after transaction)

## Loan account history

- PK TRANSACTION ID
- FK ACCOUNT ID
- date
- transaction type (withdrawal, payment)
- repayment amount
- balance (after transaction)

## Current account history

- PK TRANSACTION ID
- FK ACCOUNT ID
- date
- transaction type (withdrawal, deposit)
- amount
- balance (after transaction)

Make project extendable (have tables with 1 row) (join accounts, potential for multiple customers but for now only one)
Deleted flag (dont delete any rows, mark them as deleted instead)
Deleted date column (delete every row older than x years)

Error checking required for all fields\
Each form has to have an "Exit" or "Escape" if user changes his/her mind (i.e only update db on submit)\
-> confirmation screen after submit button pressed\
A help menu should be included with each form\
Start Up\
A welcome message, three attempts for password\
Show change password option on correct password entered on start up\
If yes chosen go to change password form, if not the simply go to main menu\

Transactions assume customer entered already exists\
Customer can have more than one account type\
Customer selection done by either typing in name, account number, or selected from a list (dropdown with text input)\
Customer details presented, then enter lodgement amount and confirm\
Are you sure displayed\
Possible option to make _more_ transactions in the same session while customer name is still entered\

Withdrawals either from deposit _or_ current account\
Check if balance is greater than the withdrawal amount requested\
(Don't forget overdraft limit)\
Printing possible for transaction\

Add new customer\
Display the unique customer number when created\
Delete customer allows you to browse through for the customer\
Customers should be <strong>flagged</strong> for deletion
#### Customer account cannot be deleted if they have an account
Double check to make sure a customer isnt accidently deleted (Are you sure Y/N)
Amend customer straight forward
Have a confirmation screen

Account maintenance menu
Deposit Account
Assume customer exists
If customer doesnt exist, add a create new customer option and then bring back to new deposit account menu
Select customer either through number or dropdown of names
- display details
Create unique acc number when details of customer are confirmed 
A first transaction should be requested to deposit an opening balance

Close deposit account
Selected using either customer number or name
Display details
Balance of account must be 0, first balance needs to be withdrawn
Account flagged for closure
Add a double check

View deposit account
Selected like any account
Display details
Display last 10 transactions
Option to browse through other customers

Loan Account Menu
Open Loan Account
Assume customer already exists
If not, same procedure as deposit account
User enters amount requested for loan, term, and monthly repayments are then calculated
- Referring to Loan rate table
User requests first transaction ie a withdrawal
Confirm details
Record end details of the transaction

Close loan account
Same as close deposit account
Only if nothing left on the loan

Amend/View loan account
Same as deposit account
Not all fields amendable
- Only change term and amount of loan
Double check 

Current Account Menu
Open current account
Same as open other accounts
Enter the overdraft limit
Option to perform a transaction

Close current account
Same as close other accounts
Check if the account is a credit or debit balance

Amend/View current account
Same as amending other accounts
last 10 transactions

Management Menu
```

Charge Interest on Overdrawn Current Accounts 
Calculate Interest on Deposit Accounts 
Calculate Interest on Current Accounts
Change rate of interest for deposit accounts 
Change rate of interest for loan accounts 
Change rate of interest for current accounts

Access by manager password (staff table)
```

Charge interest on overdrawn C account
Either manually or automatically proceed
Account chosen from list of overdrawn accounts
OR should be able to automatically charge interest to all by pressing a button
Interest calculated based off rate table
- balance updated
- recorded as transaction

Calc (short for calculate) interest on deposit accounts
Either manual or auto
Calculated based in current rate
Amount credited to account
Update balance

Calc interest on current accounts
Manual or auto
Calculated based off current rate
Update balance as transaction

Change rate of interest deposit Acc
Prompt to change new deposit rate
- also used to initialse rate
- reqs table

Change rate of interest for loan accounts 
Prompt to change new interest rate
- also used to initialse rate
- reqs table

Change interest rate for current accounts
Prompt for new interest rates, for credit and debit balances
Also used to initialise the current account
Stored in a table (Which one?????????????????????????????????????????)

Quotes Menu
```
Quote Loan Repayments 
Quote Deposit rate 
Quote Loan rate
Quote Current Account rate
```

Quote loan repayment
Prompt for amount being borrowed and the term
Then access where interest rate is stored
Output rate to the form
Amount interest charged and monthly payments calculated and displayed
Option to change interest rate
- recalculate interest charged and payments
Table with interest rates should not be changed
term not less than a month
Principal amount must be > 0

Quote deposit rate
A seperate table to store interest rates

Quote Loan Rate
separate table to store interest rates

Quote current account rate

Reports menu
```
Deposit Account History 
Loan Account History 
Current Account History 
Customer Report
Current Account Interest Report 
Account Report

```

Deposit account history
List all transactions that took place with an account
Show date, type, amount of each transactions, current balance
Option to print report
First select customer then account, allows scrolling if needed
Allow user to select between two dates eg April 2024 - June 2024 (optional maybe)

Loan account History
Show history of selected account
List all transactions
Show date, type, amount of transaction, current balance
Option to print

Current account history
List all 









```
ATTENTION CITIZEN! 市民请注意!

⣿⣿⣿⣿⣿⠟⠋⠄⠄⠄⠄⠄⠄⠄⢁⠈⢻⢿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⠃⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠄⠈⡀⠭⢿⣿⣿⣿⣿
⣿⣿⣿⣿⡟⠄⢀⣾⣿⣿⣿⣷⣶⣿⣷⣶⣶⡆⠄⠄⠄⣿⣿⣿⣿
⣿⣿⣿⣿⡇⢀⣼⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣧⠄⠄⢸⣿⣿⣿⣿
⣿⣿⣿⣿⣇⣼⣿⣿⠿⠶⠙⣿⡟⠡⣴⣿⣽⣿⣧⠄⢸⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣾⣿⣿⣟⣭⣾⣿⣷⣶⣶⣴⣶⣿⣿⢄⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣿⡟⣩⣿⣿⣿⡏⢻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣹⡋⠘⠷⣦⣀⣠⡶⠁⠈⠁⠄⣿⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣍⠃⣴⣶⡔⠒⠄⣠⢀⠄⠄⠄⡨⣿⣿⣿⣿⣿⣿
⣿⣿⣿⣿⣿⣿⣿⣦⡘⠿⣷⣿⠿⠟⠃⠄⠄⣠⡇⠈⠻⣿⣿⣿⣿
⣿⣿⣿⣿⡿⠟⠋⢁⣷⣠⠄⠄⠄⠄⣀⣠⣾⡟⠄⠄⠄⠄⠉⠙⠻
⡿⠟⠋⠁⠄⠄⠄⢸⣿⣿⡯⢓⣴⣾⣿⣿⡟⠄⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⠄⠄⣿⡟⣷⠄⠹⣿⣿⣿⡿⠁⠄⠄⠄⠄⠄⠄⠄⠄

ATTENTION CITIZEN! 市民请注意!

This is the Ministry of State Security. 您的浏览记录和活动引起了我们的注意 YOUR INTERNET ACTIVITY HAS ATTRACTED OUR ATTENTION.
同志們注意了 you have been found protesting in the forum!!!!! 這是通知你，你必須認同我們將接管台灣 serious crime 以及世界其他地方
100 social credits have been deducted from your account 這對我們未來的所有下屬來說都是重要的機會 stop the protest immediately
立即加入我們的宣傳活動，提前獲得救贖 do not do this again! 不要再这样做! if you do not hesitate, more social credits
( -11115 social credits )will be subtracted from your profile, resulting in the subtraction of ration supplies.
(由人民供应部重新分配 ccp) you'll also be sent into a re-education camp in the xinjiang uyghur autonomous zone.

为党争光! Glory to the CCP!
```
