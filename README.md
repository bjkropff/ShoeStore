# Hair Salon -Assessment 3
###Brian Kropff - March 20, 2015

Description This is an app for listing shoe stores and the brands of shoes they
carry. The user should be able to add a list of stores, and for each store, add
brands to that store. The stores have brands independently, but many storess
can have the same brand and many brands can share the same store.

## SetUp and Use
In order to use this program you will need Postgres, PSQL, and PHP.

SetUp
1. Open your terminal

2. In your terminal, type:
    a.  mkdir <folder name>
    b.  cd <folder name>
    c.  git clone https://github.com/bjkropff/assessment4_327.git .
    d.  cd web
    e.  php -S localhost:8000

3.  Open a new tab in terminal and type:
    a.  psql
    b.  CREATE DATABASE pdxadventure;
    c.  \c assessment4_327;
    d.  \i assessment4_327.sql;

3.  In a web browser window, type localhost:8000

4.  Now you should be able to see the homepage for this web app.

## Copyright (c) 2015 Brian Kropff

### The MIT License (MIT)

### PERMISSION*
Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to
do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.

### LICENSING*
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.

### psql Commands:
CREATE DATABASE shoes;
\c shoes;
CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
CREATE TABLE brands (id serial PRIMARY KEY, style varchar);
CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);
CREATE DATABASE shoes_test WITH TEMPLATE shoes;
