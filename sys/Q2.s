
###################################       instruction        #############################################################################################################
#the program will first prompt to enter the format, and if there are invalid datatype it will give error message, also, more than three it will give warning
#then, it will according to the data type and number give different prompt message
#for example, when format is '%d, %c'
#Please enter the format(no more than three): %d, %c
#Please enter the integer:   (user input and if it is not a valid integer or overflow it will give error message and exit)
#Please enter the character(no more than one):         (user input and if it is not a valid input it will give error message and exit)
#Output: 					       (there is the output)
###################################        struct            ################################################################################################
#in the main function it check the format and argument,
#loop1 is to check if all the data type is valid(if no, error and exit) and if there are more than three(if more, give warning)
#loop2 is to prompt user to input the argument according the data type and number in the format they have been input, and check if argument is valid(if no, error and quit)
#also, if format and argument is empty, program will give the error message and quit
#in the subfunction, I add some data type to print such as %c %S, also, use a funtion to upper the letter which is use in %S and change string to integer used in %d.
#also, in subfunction I handle the condition about '\n', '\\', '\'', '\"', '\t'
#this condition also be detect in loop3 in main function. if there are types undefined, program will give warning and ignore them
###################################       normal   test      ##########################################################################
############### 1.#################
#Please enter the format(no more than three): %d%%
#Please enter the integer: 100
#Output: 100%
############### 2.#################
#Please enter the format(no more than three): there are no data type
#Output: there are no data type
############### 3.#################
#Please enter the format(no more than three): suppose %S
#Please enter the string: full mark
#Output: suppose FULL MARK
############### 4.#################
#Please enter the format(no more than three): %c %d.
#Please enter the character(no more than one): A
#Please enter the integer: 100
#Output: A 100.
############### 5.#################
#Please enter the format(no more than three): %c %s.
#Please enter the character(no more than one): a
#Please enter the string: student
#Output: a student.
############### 6.#################
#Please enter the format(no more than three): %d%% %s.
#Please enter the integer: 100
#Please enter the string: mark
#Output: 100% mark.
############### 7.#################
#Please enter the format(no more than three): task: %S %s%c
#Please enter the string: a
#Please enter the string: coursework
#Please enter the character(no more than one): .
#Output: task: A coursework.
############### 8.#################
#Please enter the format(no more than three): no%c%d is %S
#Please enter the character(no more than one): .
#Please enter the integer: 1
#Please enter the string: no.1
#Output: no.1 is NO.1
############### 9.#################
#Please enter the format(no more than three): %d %S%%
#Please enter the integer: -100
#Please enter the string: 100
#Output: -100 100%
############### 10.################
#Please enter the format(no more than three): It%cs %s %S
#Please enter the character(no more than one): '
#Please enter the string: the normal
#Please enter the string: end.
#Output: It's the normal END.
######################################      abnormal   test      ########################################################
#   1-4,8  are about the wrong in argument 		5-7 is about wrong in format		9 confuse and use the mistake data type
########## 1.(in this part if user only input '-', it also error and print the same thing)##########
#Please enter the format(no more than three): %d
#Please enter the integer: asdf
#error: it is a invalid integer(float number or contain character which is not a number if invalid).
########## 2.(overflow integer)##########
#Please enter the format(no more than three): %s %d %S
#Please enter the string: bad
#Please enter the integer: 2147483648
#error: the integer is overflow(the range of integer is -2,147,483,648 and 2,147,486,647).
########## 3.(%c more than one char)##########
#Please enter the format(no more than three): %c
#Please enter the character(no more than one): asbd
#error: it is not a valid character.
########## 4.(argument is empty)##########
#Please enter the format(no more than three): %s %d %c
#Please enter the string: dfdsfsf
#Please enter the integer:  	(user directly presses enter)
#error: the argument is empty.
########## 5.(in this test, it is also shows the priority, if it is more than 3 data type, and also have invalid type, it will give the message about invalid type and exit)
#Please enter the format(no more than three): %% %c %% %e
#error: format contains invalid data type(valid data type include: %d, %c, %s, %%, %S) or only a '%' in the end.
########## 6.(format is empty)##########
#Please enter the format(no more than three): 		(user directly presses enter)
#error: the format is empty.
########## 7.(more than three data type)##########
#Please enter the format(no more than three): %c %d %s %d
#warning: because there are more than three data type, so all but the first three will be ignored.
#Please enter the character(no more than one): a
#Please enter the integer: 100
#Please enter the string: mark.
#Output: a 100 mark.
########## 8.(float number)##########
#Please enter the format(no more than three): %d
#Please enter the integer: 10.5
#error: it is a invalid integer.
########## 9.(the wrong dat type is used)##########
#Please enter the format(no more than three): %s %S
#Please enter the string: user may use wrong data type between 's' and 'S'
#Please enter the string: they have the same prompt so user cannot aware of that until program print it
#Output:user may use wrong data type between 's' and 'S' THEY HAVE THE SAME PROMPT SO USER CANNOT AWARE OF THAT UNTIL PROGRAM PRINT IT
########## 10.(program have handle the condition such as '\n', '\t'...., however, such as '\b', program not handle and ignore it)##########
#Please enter the format(no more than three): %d  \n  handle \b not handle
#warning: this several types are undefined, will be ignored: \b
#Please enter the integer: 111
#Output: 111
# handle  not handle
#
#mention: the possibility of lack of data type or argument i have been handle by check the number of data type and let user input corresponding argument
#         so there are no example about input and output
#
############################################ E N D ###############################################

## printf.asm
##
## Register Usage:
## $a0,$s0 - pointer to format string
## $a1,$s1 - format argument 1 (optional)
## $a2,$s2 - format argument 2 (optional)
## $a3,$s3 - format argument 3 (optional)
## $s4 - count of formats processed.
## $s5 - char at $s4.
## $s6 - pointer to printf buffer
##
## Source Courtesy D. J. E.
	.text
	.globl main

main:   la $a0, prompt1		#prompt to input format
	li $v0, 4
	syscall
	la $a0, buffer1		#save the format in buffer1
	li $a1, 100
	li $v0, 8
  	syscall
	la $t0, buffer1		#save address in t0 and judge if it is empty
	li $t2, 0		#record the number of data type
	lb $t1, ($t0)
	beq $t1, 10, empty_fmt  #if format is empty
	
loop1:	lb $t1, ($t0)		#loop1 check the number of data type and if it is valid
	addu $t0, $t0, 1
	beq $t1, '%', check_dataAndNumber #if char is '%', then the char follow it is data type
	beq $t1, 10, check_special	#reach end of input which is '\n'
	bne $t1, 92, loop1		#not to check it and just move the point
	addu $t0, $t0, 1
	j loop1

empty_fmt:
	la $a0, error2		#error message for empty input and quit
	li $v0, 4
	syscall
	j exit
	
check_dataAndNumber:
	lb $t1, ($t0)		#load the char behind %
	addu $t0, $t0, 1	#move one bit
	addi $t2, $t2, 1	#record the number of data type
	beq $t1, 'd', loop1
	beq $t1, 's', loop1
	beq $t1, 'c', loop1
	beq $t1, '%', loop1
	beq $t1, 'S', loop1
	la $a0, error1		#if have invalid data type, print the error message and quit
	li $v0, 4
	syscall
	j exit
	
check_special:
	la $t0, buffer1
	li $t3, 0		#check the special type such as '\n', '\t'
loop3:	lb $t1, ($t0)		#loop to check the whole prompt
	addu $t0, $t0, 1	#move one bit
	beq $t1, 92, check_type #if char is '\', then the char follow it is special type
	beq $t1, 10, preok_type	#reach end of input which is '\n'
	j loop3
check_type:
	lb $t1, ($t0)		#load the char behind \
	addu $t0, $t0, 1
	beq $t1, 'n', loop3
	beq $t1, 't', loop3
	beq $t1, '"', loop3
	beq $t1, 92, loop3
	beq $t1, 39, loop3
	addi $t3, $t3, 1	#if user give a invalid type such as '\b', '\a', the first it give the warning message and which is invalid
	bgt $t3, 1, not_warning #if warning message have give once than just show users where their input is valid 
	la $a0, wrong_type
	li $v0, 4
	syscall
not_warning:
	li $a0, 92		#print the wrong type such as '\b '
	li $v0, 11
	syscall
	move $a0, $t1
	li $v0, 11
	syscall
	li $a0, 32
	li $v0, 11
	syscall
	j loop3

preok_type:
	beq $t3, 0, ok_type 	#if not give warning, do not need a new line, otherwise, need
	la $a0, new_line
	li $v0, 4
	syscall
ok_type:
	slti $t3, $t2, 4	#check if there more than 3
	li $t2, 0		#also use t2 to count number of data type in loop2 and t0 to save address of format
	la $t0, buffer1
	beq $t3, 1, loop2	#if the number of data type less than 4 jump to loop2
over_number:
	la $a0, too_many	#if there are more than 3, print the warning messey
	li $v0, 4
	syscall

loop2:	lb $t1, ($t0)		# get character and move , if it is a normal character do not care and continue loop until reach end or some error
	addu $t0, $t0, 1
	beq $t1, '%', prompt_fmt# jump to see the data type 
	beq $t1, 92, prompt_special
	beq $t1, '\n', to_print # the end of format
	j loop2
prompt_fmt:
	lb $t1, ($t0) 		# get the char after '%' and move pointer one bit
	addu $t0, $t0, 1
	beq $t2, 3, loop2 	#there is only use when there are more than three data type, ignore it 
	addi $t2, $t2, 1
	beq $t1, 'd', prompt_int
	beq $t1, 's', prompt_str
	beq $t1, 'c', prompt_char
	beq $t1, '%', loop2	 #s it is special because % do not need prompt or save things in buffer
	beq $t1, 'S', prompt_Str #in loop1 detect each dat type, so just this five possible condition
	
prompt_special:
	addu $t0, $t0, 1	#use to move one bits and if 
	j loop2
	

save_buffer2:
	la $a0, buffer2		#save the argument1
	li $a1, 100
	li $v0, 8
  	syscall
  	la $t7, buffer2		#judge if argument is empty, if empty jump to print error message
  	j judge_argument
save_buffer3:
	la $a0, buffer3		#same as save_buffer2
	li $a1, 100
	li $v0, 8
  	syscall
    	la $t7, buffer3
  	j judge_argument
save_buffer4:
	la $a0, buffer4		#same as save_buffer 
	li $a1, 100
	li $v0, 8
  	syscall
    	la $t7, buffer4		#judge if argument is empty, and use to judge int, char, elimite '\n' below
judge_argument:
  	lb $t1, ($t7)
  	beq $t1, 10, argu_empty #if argument is empty
  	beq $t3, 0, elimite_changeline#if it is string need to change the '\n' in the end of string to '\0'
 	beq $t3, 1, judge_int	#if it is int, it need to judge if it is valid
 	beq $t3, 2, judge_char	#if it is char, it need to judge if it is valid
  	j loop2
  	
elimite_changeline:
loop_1:	addu $t7, $t7, 1	#move untill meet '\n' and change it to '\0'
	lb $t1, ($t7)
	beq $t1, 10, elimite	#meet '\n'
	j loop_1
elimite:addi $t1, $t1, -10	#change to '\0' and save
	sb $t1, ($t7)
	j loop2
 
argu_empty:
	la $a0, error3		#print the error message and quit
	li $v0, 4
	syscall
	j exit

prompt_int:
	li $t3, 1			#use in judge_argument to check if it is valid int
	la $a0, prompt2			#prompt to input arg1
	li $v0, 4
	syscall
	j choose_buffer
prompt_str:
	li $t3, 0			#use in judge_argument to change '\n' to '\0'
	la $a0, prompt3			#print the output message
	li $v0, 4
	syscall
	j choose_buffer
prompt_char:
	li $t3, 2			#use in judge_argument to check if it is valid char
	la $a0, prompt4			#print the output message
	li $v0, 4
	syscall
	j choose_buffer
prompt_Str:
	li $t3, 0			#use in judge_argument to change '\n' to '\0'
	la $a0, prompt3			#print the output message
	li $v0, 4
	syscall
choose_buffer:
	beq $t2, 1, save_buffer2	#judge where to save, below do the same thing
	beq $t2, 2, save_buffer3
	beq $t2, 3, save_buffer4

judge_int:
	lb $t1, ($t7)			# loop to check if it is a valid int
	li $t3, 0			#use t3 to save the value of int, to compare if it will be overflow
        beq $t1, 10, argu_empty
        li $t6, 214748364	#use to compare if input is overflow
        li $t5, 7			#when it is a positive integer it cannot over than 2,147,483,647(overflow)
        bne $t1, 45, loop_a
        li $t5, 8			#when it is a negative integer the modulus of it cannot over than 2,147,483,648(overflow)
        addu $t7, $t7, 1		#if it is negative check from the second char
        lb $t1, ($t7)
        beq $t1, '\n', invalid_int	#if there are just one '-'
loop_a: lb $t1, ($t7)			#loop to load char and check
 	addu $t7, $t7, 1
 	beq $t1, 10, loop2		#end of input is '\n', ascii number is 10, valid integer
    	blt $t1, '0', invalid_int	#check if t1 is '0-9'
	bgt $t1, '9', invalid_int
 	addi $t1, $t1, -48		#change ascii number to '0-9'
 	bgt $t3, $t6, int_overflow
 	beq $t3, $t6, may_overflow	#if t3 is equal to overflownumber/10, then compare the unit digit
    	mul $t3, $t3, 10		#t3 = t3 * 10 + t1
 	add $t3, $t3, $t1
        j loop_a
invalid_int:
	la $a0, error			#print error message about invalid integer and quit
	li $v0, 4
	syscall
	j exit
may_overflow:
	bgt $t1, $t5, int_overflow	#judge unit digit and overflow number's unit diget
	j loop_a
int_overflow:
	la $a0, error5			#print error message about overflow and quit
	li $v0, 4
	syscall
	j exit
	
judge_char:
	lb $t1, 1($t7)			#judge if it is over than one char: check the second char is '\n' or not
	beq $t1, 10, loop2
	la $a0, error4			#if it is more than one character, print error message and quit
	li $v0, 4
	syscall
	j exit
	
to_print:
	la $a0, output			#print the output message
	li $v0, 4
	syscall
	la $a0, buffer1			# move fmt arg1 arg2 arg3 to a0 a1 a2 a3
	la $a1, buffer2
	la $a2, buffer3
	la $a3, buffer4
	jal printf			#call subfunction
	j exit
########################################################
## Your test code starts here. ##
## You may add test data in the .data segment. ##
########################################################

printf:
	subu $sp, $sp, 36 # set up the stack frame
	sw $ra, 32($sp) # save local variables
	sw $fp, 28($sp)
	sw $s0, 24($sp)
	sw $s1, 20($sp)
	sw $s2, 16($sp)
	sw $s3, 12($sp)
	sw $s4, 8($sp)
	sw $s5, 4($sp)
	sw $s6, 0($sp)
	addu $fp, $sp, 36
	# grab the arguments
	move $s0, $a0 # fmt string
	move $s1, $a1 # arg1, optional
	move $s2, $a2 # arg2, optional
	move $s3, $a3 # arg3, optional
	li $s4, 0 # set # of fmt = 0
	la $s6, printf_buf # set s6 = base of buffer

printf_loop: # process each character at fmt
	lb $s5, 0($s0) # get the next character
	addu $s0, $s0, 1 # $s0 pointer increases
	beq $s5, '%', printf_fmt
	beq $s5, 92, printf_special
	beq $0, $s5, printf_end # if zero, finish

printf_putc:
	sb $s5, 0($s6) # otherwise, put this char
	sb $0, 1($s6) # into the print buffer
	move $a0, $s6 # and print it using syscall
	li $v0, 4
	syscall
	j printf_loop

printf_fmt:
	lb $s5, 0($s0) # get the char after '%'
	addu $s0, $s0, 1
	# check if already processed 3 args.
	beq $s4, 3, printf_loop
	# if 'd', then print as a decimal integer
	beq $s5, 'd', printf_int
	# if 's', then print as a string
	beq $s5, 's', printf_str
	# if 'c', then print as an ASCII char
	beq $s5, 'c', printf_char
	# if '%', then print as a '%'
	beq $s5, '%', printf_perc
	# if 'S', then print as a string (all the ch to be upper)
	beq $s5, 'S', printf_Str
	# other thing follow by %
	j printf_loop

printf_shift_args:
	move $s1, $s2
	move $s2, $s3
	addi $s4, $s4, 1 # increment no. of args processed
	j printf_loop

printf_int:
	move $t0, $s1			#save address in t0
	li $t2, 0			#use to save the number
	lb $t1, ($t0)			# check if it a negative number, use a different to convert
        beq $t1, 45, int_negative
loop_c: lb $t1, ($t0)			#loop to change string to positive int
 	addu $t0, $t0, 1
 	beq $t1, 10, print_it		#reach the end of string
    	addi $t1, $t1, -48
    	mul $t2, $t2, 10		#t2 = t2 * 10 + t1
    	add $t2, $t2, $t1
        j loop_c
int_negative:				
loop_d:	addu $t0, $t0, 1		#loop to change string to negative int
	lb $t1, ($t0)
 	beq $t1, 10, print_it		#reach the end of string
    	addi $t1, $t1, -48
    	mul $t2, $t2, 10		#t2 = t2 * 10 - t1
        sub $t2, $t2, $t1
        j loop_d
print_it:
	move $a0, $t2			#print the integer argument
	li $v0, 1
	syscall
	j printf_shift_args

printf_str: 				#printf string
	move $a0, $s1
	li $v0, 4
	syscall
	j printf_shift_args

printf_char:				#printf char
	lb $a0, ($s1)
	li $v0, 11
	syscall
	j printf_shift_args

printf_perc:				#printf '$'
	lb $a0, symbol
	li $v0, 11
	syscall
	j printf_shift_args
	
printf_Str:				#printf string which all letters are upper letter
	move $a0, $s1
	jal toUpper			# call the subfunction to upper the letter
	move $a0, $v0			# print the argument after upper
        li $v0, 4
	syscall
        j printf_shift_args
toUpper:
	move $t2, $a0			#use t2 to save the address
loop:	lb $t0, ($t2)			#check each character if it is lower change to upper
        beq $t0, 0, upperEnd		#reach the end of string, mention, this place is '\0'
    	blt $t0, 'a', not_letter	#ascii number of 'a-z' is '97-122'
	bgt $t0, 'z', not_letter
        addi $t0, $t0, -32		#change lower letter to upper
        sb  $t0, ($t2)			#save the upper
not_letter:
        addu $t2, $t2, 1		#move to next character
        j loop
upperEnd:
        move $v0, $a0
        jr $ra				#finish and back
        
printf_special:
	lb $s5, 0($s0) # get the char after '\'
	addu $s0, $s0, 1
	# if 'n', then print a new line
	beq $s5, 'n', printf_newline
	# if '\', then print a backslash
	beq $s5, 92, printf_backslash
	# if ''', then print single quotation(close)
	beq $s5, 39, printf_singlequote
	# if '"', then print double quotations
	beq $s5, '"', printf_doublequote
	# if 't', then print eight blank
	beq $s5, 't', printf_blank
	# other thing follow by % not care
	beq $s5, '\n', printf_end
	j printf_loop

printf_newline:
	la $a0, new_line	#print a new line
	li $v0, 4
	syscall
	j printf_loop
printf_backslash:
	move $a0, $s5		#print a '\'
	li $v0, 11
	syscall
	j printf_loop
printf_singlequote:
	move $a0, $s5		#print a '''
	li $v0, 11
	syscall
	j printf_loop
printf_doublequote:
	move $a0, $s5		#print a '"'
	li $v0, 11
	syscall
	j printf_loop
printf_blank:
	la $a0, blank		#print a eight blank
	li $v0, 4
	syscall
	j printf_loop

#############################################################
## You may add code to process string, char, ��%�� here. ##
#############################################################

printf_end:
	lw $ra, 32($sp)
	lw $fp, 28($sp)
	lw $s0, 24($sp)
	lw $s1, 20($sp)
	lw $s2, 16($sp)
	lw $s3, 12($sp)
	lw $s4, 8($sp)
	lw $s5, 4($sp)
	lw $s6, 0($sp)
	addu $sp, $sp, 36
	jr $ra

exit:
	li $v0, 10
	syscall

##############################################################
## You may add whatever necessary in the .data segment. ##
##############################################################

	.data
	printf_buf: .space 2
	buffer1: .space 100
	buffer2: .space 100
	buffer3: .space 100
	buffer4: .space 100
	too_many: .asciiz "warning: because there are more than three data type, so all but the first three will be ignored.\n"
	wrong_type: .asciiz "warning: this several types are undefined, will be ignored: " 
	prompt1: .asciiz "Please enter the format(no more than three): "
	prompt2: .asciiz "Please enter the integer: "
	prompt3: .asciiz "Please enter the string: "
	prompt4: .asciiz "Please enter the character(no more than one): "
	output: .asciiz "Output: "
	symbol: .asciiz "%"
	error: .asciiz "error: it is a invalid integer(float number or contain character which is not a number if invalid).\n"
	error1: .asciiz "error: format contains invalid data type(valid data type include: %d, %c, %s, %%, %S) or only a '%' in the end.\n"
	error2: .asciiz "error: the format is empty.\n"
	error3: .asciiz "error: the argument is empty.\n"
	error4: .asciiz "error: it is not a valid character.\n"
	error5: .asciiz "error: the integer is overflow(the range of integer is -2,147,483,648 and 2,147,486,647).\n"
	new_line: .asciiz "\n"
	blank: .asciiz "        "

## end of printf.asm ##
