// first set R3 = 1 and R2 = 0, then judge the value of base number(x) 
// if x = 0, jump to judge the value of y, if y is zero, set R3 = -1, R2 = -1 and out. if y > 0, directly jump to out.
// if x > 0, set R2 = 1, save the index(y) in R18 used to minus 1 at one time until R18(index) = 0, then loop1 stop and out
// each time R18(index) minus 1, loop2 execute once, loop2 is similar to multiple, use the R2 to mult the base number(x), 
// use R17 in loop2 to temporary save the result and pass the result to R2, when loop2 stop. R16 in loop2 is to record the times of loop and compare with base number(x)
// principle: result = x * ... * x(the number of x is y) and use loop1 to see if enough x mult together, 
//			  use loop2 to let previous result(x * ... * x) mult x, which is let (x * ... * x) add itself (x - 1) times

// R0 user input x
// R1 user input y
// R2 output z
// R3 output -1 when x = 0, y = 0, otherwise, R3 = 1
// R16 record the times of loop2 and compare with base number(x)
// R17 temp save the result of loop2 and pass it to R2 in the end
// R18 save the number(index) and compare with 0, each time loop2 finish it will minus 1

// label
// loop1: see x^y as result = x * ... * x(the number of x is y), and compare R18(index) with 0, if R18 is great than 0, then execute loop2 and R18 minus 1 
// loop2:  the principle of loop 2 is R17 = R2 + ... + R2(the number of R2 is base number(x)), if R16(which use to record) = x, then loop2 stop and jump to stop
// stop: this label will let R18 minus 1, pass R17 to R2 and jump to loop1
// if: when x = 0, check if y = 0 set R2 = -1, R3 = -1, or y not equal to 0 and directly jump to end

@3				// set R3 = 1 and R2 = 0
M=1
@2
M=0
@0				// judge the value of x, if x = 0, jump to judge the value of y
D=M
@IF
D;JEQ


@2				// set R2 = 1
M=M+1
@1
D=M
@18				// use R18 to save the index(y)
M=D
// see x^y as result = x * ... * x(the number of x is y)
(LOOP1)
@18				// save the number(index) in D
D=M
@OUT			// if R18(index) = 0, then loop1 stop and jump to out
D;JEQ

@16				// R16 to record the times of loop2 and compare with the base number(x)
M=1
@17				// R17 temp save the result in loop2 and pass it to R2 in the end
M=0 
// the principle of loop 2 is R17 = R2 + ... + R2(the number of R2 is base number(x)), and pass R17 to R2
(LOOP2)			// same as mult
@16
D=M
@0				// compare the R16 and R0(base number) R16 - R0
D=D-M
@STOP			// if it loop enough times, then loop2 stop
D;JGT
@2
D=M
@17				// R17 = R17 + R2
M=D+M
@16				// the times of loop2 plus 1
M=M+1
@LOOP2
0;JMP
(STOP)
@17				// let the result save in R2
D=M
@2
M=D
@18				// R18(index) minus 1
M=M-1
@LOOP1			// jump to continue the loop1
0;JMP

(IF)
@1				
D=M
@OUT			// if y > 0, jump to out
D;JGT
@2				// if y = 0, set R2 = -1 and R3 = -1
M=M-1
@3
M=-1
(OUT)
@OUT
0;JMP
