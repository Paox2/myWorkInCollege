// first save the base number in R1 to compare with R0 and initial the number in R2 (R2 = 2^1)
// then loop start, compare R1(which is the 2^n, the number of n is decided by the times of loop) and R0
// if R1 is great than R0, loop stop and quit, R2 is the result
// else, R1 = R1 * 2(from 2^(n) to 2^(n+1)) and R2 add 1, continue to loop

// R0 user input
// R1 stand for 2^n (where n is 1,2,3,4...)
// R2 output

// loop: change the value of R1 and compare with R0, increase R2

@2			//save base number 2 in R1
D=A
@R1
M=D
@R2			//initialize R2 to 0
M=0
(loop) 
@R0
D=M
@R1			// judge if R0 is great than R1, if true then continue to loop
D=D-M
@out		// if R0 is not great than R1, then out
D;JLT

@R1			// R1 = R1 * 2(because base number is 2)
D=M
@R1
M=D+M
@R2			// result add 1
M=M+1
@loop
0;JMP
(out)		// end 
@out
0;JMP
