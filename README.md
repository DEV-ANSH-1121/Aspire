# Aspire App

PHP Version : 8.0
Laravel Version : 9.0

To clone the project use this git command:
# git clone https://github.com/DEV-ANSH-1121/Aspire
# cd Aspire
# composer update

Add an .env file and setup database details

Use the following command to migrate:
# php artisan migrate


Use following Postman Collection to test the APIs:
# https://cloudy-equinox-834089.postman.co/workspace/c3788e37-8810-4608-8230-7cbfa4be0c0d


API Lists:

Collection : Auth
# Register User : Use this API to register user.
# Login User : Use this API to login.

Collection : Loan (Authentication Requierd)
# Create Loan : Use this API to create loan.
# Loan Repayment : Use this API to make loan installment payment.
# Get Loan by Status : Use this API to get loan of logged-in user by loan status.

Collection : Admin (Admin Authentication Requierd)
# Update Loan : Use this API to update status of loan.
# Get All Loans : Use this API to get list of all loans.