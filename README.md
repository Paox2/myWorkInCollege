>a student in nottingham Ningbo China
# UNNC_cw

This part is my coursework in UNNC since the second semester. If you have some question or want to access the issue sheet can try to contact me. Also the method is not optimal, there are some areas can be improved. If you have some better ideas or find something that can be optimized, please contact me.

# Overview

 course | title
 -|-
 c | [airstrikeplanner](../c/"airstrikeplanner.c")
 cf | [chip](../cf/cw1) <br/> [assembler](../cf/cw2)
 sys | [fibonacci](../sys/Q1.s) <br/> [printf](../sys/Q2.s)

# Introduce to each work

### airstrikeplanner: Use c to write a program to plan air strike.

&nbsp; struct AIMINFO
> use struct to save the infomation of aim, i.e. name, latitude, longitude
<br/>

&nbsp; struct List
> to save a queue of aim
<br/>

&nbsp; char* s_gets(char *st, int n)       
> gets input and deal with useless input(clear buffer)
<br/>

&nbsp; void free_struct(list *L)			
> free the whole linked list
<br/>

&nbsp; void buffer_clear(void)
> clear the buffer
<br/>

&nbsp; int judge_input(const char *prompt[], double arr[])
> use in option 4 and option 5 to check the input
<br/>

&nbsp; int judge_file(FILE *fp)
> check if file name is valid or the content valid
<br/>

&nbsp; int judge_conflict(list *L, list *k)
> judge if it is conflict between different aim
<br/>

&nbsp; void list *store_target(FILE *fp, list *L)
> save the target in the linked list
<br/>

&nbsp; list *load_file(list *L)
> load file
<br/>

&nbsp; void buffer_clear(void)
> clear the buffer
<br/>

&nbsp; void print_map(char map[][map_width])
> show the map
<br/>

&nbsp; void search_target(list *L)
> search if target in the linked list
<br/>

&nbsp; void plan_airstrike(list *L)
> plan the air strike
<br/>

&nbsp; int delete_target(list *L, list *n, double *arr)
> delete the target which has been destroyed
<br/>

&nbsp; void print_destroy(list *m)
> print the destroyed target
<br/>

&nbsp; list *execute_airstrike(list *L)
> excute air strike
<br/>

### chip in cf

Use gate to implement substract chip, multiple chip, exponential chip, compare chip, and check if result is overflow.
You can access the report click [here](../cf/cw1/readme.pdf)

### assembler in cf

Task 1: To implement a division function of integers z=x/y, where x, y, z are integers, and z is the round-off value of x/y.
<br/>
Task 2: To implement a power function of integers z=x^y, where x, y, z are non-negative integers.
<br/>
Task 3: To implement a log function of integers z=log x, where x is a positive integer, and z = log x returns the logarithm of x, where the base is 2. z is rounded down to the nearest integer

###  fib and printf in sys

Both use MIPS to implement fibonacci and printf(in c but not entirely same)
