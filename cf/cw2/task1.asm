// first, set R2 = 0, R3 = 1, then judge if y = 0 or not(line 10-17), if true set R3 = -1 and R2 = -1 and jump to out(line 110-117)
// second, judge if x = 0 or not, directly jump to out(line 18-21)
// third, get the modulus of x and y and save them in R14 and R15. At the same time, use R16 record the sign of them which decide the sign of result(if R16 = -1 then result is negative, otherwise, positive)(line 23-54)
// four, loop to get the value without round-off(line 56-68)
// five, judge if out should be positive or negative and according to the sign judge how to round-off(line 71-74 for judge, 74-91 for negative round-off, 93-105 for positive round-off)
// (for round-off, if result should to be positive then when fractional part >= .5, the result should plus 1. if it is negative, then when fractional part > .5, its modulus plus 1)
// final, out 

// R0 user input x
// R1 user input y
// R2 output z
// R3 if y = 0, R3 = -1, otherwise, R3 = 1
// R14 save the modulus of x
// R15 save modulus of y
// R16 record the sign

// label
// change: if y = 0, jump to this label to set R3 = -1 and R2 = -1 and out
// jump1: if x is positive jump to this label and not get the opposite of x
// loop: jump to that if y is positive, this label is use to get the round result of x/y which not consider the fractional
// judge: judge the sign of result use R16
// jump: use in negative when the modulus of result do not need to add 1
// positive: if it is positive number, jump this label to round-off(which is different negative number round-off)

@3				//initialize R3 = 1 and R2 = 0
M=1
@2
M=0
@1				// get the value in R1(y)
D=M
@CHANGE			// if y = 0
D;JEQ
@0				// get the value of R0(x)
D=M
@end			// if x = 0
D;JEQ

@0
D=M
@14				// save x in R14
M=D
@1
D=M
@15				// save y in R15
M=D

@16				//initialize R16 = 0 and use to record sign
M=0
@14
D=M
@jump1			// if x is a positive number then do not need to get modulus
D;JGT
@0
D=A
@14				// if x is negative, R14 = 0 - x
M=D-M
@16				// R16 = R16 - 1 , which means x is  negative number
M=-1
(jump1)
@15
D=M
@loop			// if y is a positive number then do not need to get modulus
D;JGT
@0
D=A
@15				// if y is negative, R15 = 0 - y
M=D-M
@16
M=M-1			// R16 = R16 - 1, which means y is  negative number

(loop)
@15
D=M
@14				// D = R14 - R15
D=M-D
@judge			// if R14 > R15, jump to judge the sign of result and round-off according to the sign
D;JLT
@14				// if R14 <= R15, R14 = D = R14 - R15
M=D
@2				// z = z + 1
M=M+1
@loop
0;JMP

(judge)
@16
D=M+1
@positive		// if R16 not equal to -1 then the result should to be positive
D;JNE
@15				// R15 is y and R14 is the reminder
D=M
@14				// D = R15 - R14
D=D-M
@14				// D = R15 - R14 - R14
D=D-M
@jump			// if D >= 0, which mean the fractional part <= .5, then jump and not to plus 1
D;JGE
@2				// if great than .5 then plus one 
M=M+1
(jump)
@0				// let R2 = 0 - R2
D=A
@2
M=D-M
@end			// jump to out
0;JMP

(positive)
@15				// R15 is y and R14 is the reminder
D=M
@14				// D = R15 - R14
D=D-M
@14				// D = R15 - R14 - R14
D=D-M
@end			// if D > 0, which mean the fractional part < .5, then jump to out and not plus 1
D;JGT
@2				// if >= .5 then plus one 
M=M+1
@end
0;JMP

(CHANGE)
@3				// y = 0, set R3 & R2 = -1
M=-1
@2
M=-1
(end)
@end			// end
0;JMP
