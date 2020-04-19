
##################################################     stucture     ################################################################
# this program is so long, because it give different message when user input different wrong value
# in the main function there are main three part, one is base case, loop is program give user three chances to give a valid input, loop1 is check the input
# subfunction is let F(n-1) save in a register t2(may same as pointer save in one address and update) and pass to upper function as F(n-2) 
# and F(n) save in v0 as the return value pass to the upper fuction as F(n-1) .In the upper function, it will use F(n-2) and that value to calculate the F(n)
# recursive first save the return address and recusive let n minus 1 at one time, then call itself until n come to 1, which is the base case and then return value to upper function
# the advantage of it is that do not need to save too much value in stack. Also, do not need to call itself in one function twice to get F(n-1) and F(n-2), because n-2 save in one register
# This way greatly improve the speed of running
# line 150-169 is subfuntion, 34-125 three chance to judge input, 47-57 is judge if input if valid
# line 59-75 judge negative input, 77-81 judge no input, 83-88 char, 90-101 float, 103-114 overflow
# priority of wrong input: no_input = char > float > negative > overflow

################################################### read instruction ##################################################################
# input: a nonnegative integer less than 47(because 47 or more will cause overflow)
# output: a nonnegative integer(the fibonacci number in the input number's postion)

         .data
buffer:  .space 100
prompt:  .asciiz "Please enter a nonnegative integer less than 47: "
end:     .asciiz "The fibonacci number is: "
error1:   .asciiz "The user need to input something. Remain chance: "
error2:	 .asciiz "Input cannot contain character. Remain chance: "
error3:  .asciiz "Input cannot be a float. Remain chance: "
error4:	 .asciiz "Input cannot be a negative number. Remain chance: "
error5:  .asciiz "Input value is too large, it will cause overflow, please input less than 47. Remain chance: "
fail_message: .asciiz "Sorry, you have no chance."
new_line: .asciiz "\n"
         .text
	 .globl main
	
main:  	li $t0, 2			#user have three time to give a valid input
###### loop is check if user waste three input chances from line32 to 127
loop:	la $a0, prompt          	#prompt user to input
        li $v0, 4
	syscall
	la $a0, buffer			#save user's input
	li $a1, 100
	li $v0, 8
  	syscall
	la $t3, buffer			#use t3 to save adress
	lb $t4, ($t3)
	beq $t4, 10, no_input		#if input is empty or first char is '-', jump
	beq $t4, 45, may_negative
	li $t2, 0			#follow step, change string to int save in t2
###### loop1 to detect each char
loop1:	lb $t4, ($t3)
        beq $t4, 10, valid 		#the end of input is '\n'
    	addi $t3, $t3, 1		#move one byte
    	blt $t4, '0', contain_char	#check if t1 is '0-9'
	bgt $t4, '9', contain_char
    	addi $t4, $t4, -48		#t2 = t2 * 10 + t4, let t4 ascii number change to '0-9'
    	mul $t2, $t2, 10
    	add $t2, $t2, $t4
    	slti $t5, $t2, 47		#when n >= 47, it will overflow and jump to overflow
    	beq $t5, $0, may_overflow
        j loop1
        
may_negative:
	addi $t3, $t3, 1		#first consider the condition that user input is '-0', see as '0'
	lb $t4, ($t3)
	bne $t4, '0', loop2
	lb $t4, 1($t3)
	beq $t4, '\n', valid		#if user input is '-0', then it is valid
loop2:	addi $t3, $t3, 1		#first char is '-', so first move pointer then load each char
	lb $t4, ($t3)
        beq $t4, 10, is_negative 	#reach the end of input which is '\0' and it is negative input
    	blt $t4, '0', contain_char	#check if t1 is '0-9'
	bgt $t4, '9', contain_char
    	j loop2
is_negative:  
	la $a0, error4			#print the error message
	li $v0, 4
	syscall  	
    	j invalid
	
no_input:
	la $a0, error1			#user input nothing, give the error message
	li $v0, 4
	syscall
	j invalid
	
contain_char:
	beq $t4, 46, may_float		#if this char is '.', then number may be float
char:	la $a0, error2			#if contain char give the error message
	li $v0, 4
	syscall
	j invalid
	
may_float:
loop3:	addi $t3, $t3, 1		#loop to detect if there are another char
	lb $t4, ($t3)
        beq $t4, 10, input_float 	#reach the end of input which is '\n'
    	blt $t4, '0', char		#check if t1 is '0-9'
	bgt $t4, '9', char
    	j loop3
input_float:
	la $a0, error3			#user input float give the wrong message
	li $v0, 4
	syscall
	j invalid

may_overflow:				#the priority of char is higher than overflow, so still need to check other character
loop4:	lb $t4, ($t3)
	addi $t3, $t3, 1
        beq $t4, 10, input_overflow 	#reach the end of input '\n'
    	blt $t4, '0', contain_char	#check if t1 is '0-9'
	bgt $t4, '9', contain_char
    	j loop4
input_overflow:
	la $a0, error5			#the wrong message about overflow
	li $v0, 4
	syscall
	j invalid
	    	
invalid:
	move $a0, $t0			#print the remain chance
	li $v0, 1
	syscall
	la $a0, new_line		#change a new line
	li $v0, 4
	syscall
	beq $t0, 0, fail		#no chance and fail
	addi $t0, $t0, -1		#chance minus 1
	j loop
	
fail:	la $a0, fail_message		#print the fail message and quit
	li $v0, 4
	syscall
	li $v0, 10
	syscall
	 
valid:	move $a0, $t2           	#save the number in a0 pass to callee
	jal f				#call recursive function

direct_out:
	move $s0, $v0			#temp save the result
        la $a0, end              	#print the end message
        li $v0, 4
	syscall
	move $a0, $s0
	li $v0, 1                	#print the result and quit
	syscall
	li $v0, 10
	syscall
	 
# for recursive, save F(n-1) in a register and F(n) as a return value return to the upper function until the return address is in the main function
# F(n-1) and F(n) are seen as F(n-2) and F(n-1) in the upper function and use to calculate F(n)
# advantage: faster 		reason: save and load less value in stack, use register reduce the time in recursive(function call itself)
f: 	addi $sp, $sp, -4 	#save $ra
 	sw $ra, ($sp)
 	beq $a0, 0, base_case	#base case n = 0
	beq $a0, 1, base_case1	#base case n = 1
	addi $a0, $a0, -1
	jal f			#call itself, this is the recusion step
	add $t4, $v0, $t2 	#let t4 = f(n-1)+f(n-2)
	move $t2, $v0 		#let t2 = f(n-1) 	(if not back to main fuction, it will be seen as F(n-2))
	move $v0, $t4 		#let v0 = f(n) 		(if back to main fuction, it is F(n), if not, it will be seen as F(n-1))
	j f_return
base_case:
	li $v0, 0		#F(0) = 0
	j f_return
base_case1:
	li $v0, 1		#F(1) = 1
	li $t2, 0		#when n not equal to 1 in the beginning, use this register to save F(n-2)
f_return:
	lw $ra, ($sp) 		#pop $ra
	addi $sp, $sp, 4
	jr $ra 			#back to caller
