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

## Deposit account

- PK ACCOUNT ID
- account number (generated unique random number)
- FK customer no
- address
- eircode
- date of birth
- balance
- deleted flag

## Loan account

- PK ACCOUNT ID
- account number
- FK customer no
- address
- date of birth
- balance
- loan amount
- loan term
- loan monthly repayments
- deleted flag

## Current account

- PK ACCOUNT ID
- account number
- FK customer no
- address
- eircode
- date of birth
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
- opening balance
- closing balance
-

## Loan account history

- PK TRANSACTION ID
- FK ACCOUNT ID
- date
- transaction type (withdrawal, payment)
- repayment amount
- balance

## Current account history

- PK TRANSACTION ID
- FK ACCOUNT ID
- date
- transaction type (withdrawal, deposit)
- amount
- balance

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
