# LoginPro
[![Issues](https://img.shields.io/github/issues/masoudnabavi/login_pro?label=Issues)](https://img.shields.io/github/issues/masoudnabavi/login_pro)
[![Stars](https://img.shields.io/github/stars/masoudnabavi/login_pro)](https://img.shields.io/github/stars/masoudnabavi/login_pro)

This is a library for logging in and authenticating in the system, which has features such as: login with password and without password, login with username, mobile, code, email, working with this library is very easy.

## Install
```bash
composer require masoudnabavi/login_pro
```
## Add to .env file

```bash
usePassword=0  // 0 means you Dont Want To Use Password And 1 means You Want To Use Password
useCookie=0    // 0 means use Session And 1 means Use Cookie
sentCodeLimitNumber=3  //The number of times a user can receive a 2Step Code before their account is blocked
```
