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

## Deposit account

- PK ACCOUNT ID
- account number (generated unique random number)
- customer name
- address
- eircode
- date of birth
- customer no
- balance

## Loan account

- PK ACCOUNT ID
- account number
- customer name
- address
- date of birth
- customer no
- balance
- loan amount
- loan term
- loan monthly repayments

## Current account

- PK ACCOUNT ID
- account number
- customer name
- address
- eircode
- date of birth
- customer no
- balance
- overdraft limit

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

## Quote deposit rate table

- current deposit rate for loans (XX.XX%)

## Quote loan rate table

- current interest rate for loans (XX.XX%)

## Quote current account rate table

- interest on credit balances (XX.XX%)
- interest on overdrawn balances (XX.XX%)

## Deposit account history

- PK TRANSACTION ID
- FK ACCOUNT ID
- date
- transaction type
- transaction amount
- balance

## Loan account history

- PK TRANSACTION ID
  FK ACCOUNT ID
- date
- transaction type
- repayment amount
- balance

## Current account history

- PK TRANSACTION ID
  FK ACCOUNT ID
- date
- transaction type
- amount
- balance

Make project extendable (have tables with 1 row) (join accounts, potential for multiple customers but for now only one)
Deleted flag (dont delete any rows, mark them as deleted instead)
Deleted date column (delete every row older than x years)

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
