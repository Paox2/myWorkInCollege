import static org.junit.jupiter.api.Assertions.*;
import static org.junit.Assert.assertEquals;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.PrintStream;

import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;

class BoCAppTest {
	
    private static InputStream standardIn;
    private static PrintStream standardOut;
    private static String newLine;
    
    private static String menu;
    private static String exit;
    private static String promptsInAddTransaction1;
    private static String promptsInAddTransaction2;
    private static String promptsInChangeTransactionCategory1;
    private static String promptsInChangeTransactionCategory2;
    private static String promptsInAddCategory1;
    private static String promptsInAddCategory2;
    private static String overviewCategorySetInMain;
    private static String overviewTransactionSetInMain;
    private static String ListTransactionsSetInMain;
    private static String invalidNumberWrong;
    @BeforeAll
    public static void setUp()
    {
        // make sure newline characters is only \n
    	// prevent different in "\r\n" and "\n"
        newLine = System.getProperty("line.separator");
        System.setProperty("line.separator", "\n");

        standardIn = System.in;
        standardOut = System.out;
        
        menu = "\nWhat do you want to do?\n O = [O]verview, T = List All [T]ransactions, [num] = Show Category [num], C = [C]hange Transaction Category, A = [A]dd Transaction, N = [N]ew Category, X = E[x]it\n";
        exit = "Goodbye!\n";
        promptsInAddTransaction1 = "What is the title of the transaction?\nWhat is the value of the transaction?\n";
        promptsInAddTransaction2 = "What category do you want to add?\n[Water Bill](¥9.00) was added to [Bills]\n";
        promptsInChangeTransactionCategory1 = "Which transaction ID?\n";
        promptsInChangeTransactionCategory2 = "Which category will it move to?\n";
        promptsInAddCategory1 = "What is the title of the category?\n";
        promptsInAddCategory2 = "What is the budget for this category?\n";
        overviewCategorySetInMain = 
        		"1) [Unknown](Budget: ¥0.00) - ¥850.00 (¥850.00 Overspent)\n" +
        		"2) [Bills](Budget: ¥120.00) - ¥112.99 (¥7.01 Remaining)\n" +
        		"3) [Groceries](Budget: ¥75.00) - ¥31.00 (¥44.00 Remaining)\n" +
        		"4) [Social](Budget: ¥100.00) - ¥22.49 (¥77.51 Remaining)\n" ;
        overviewTransactionSetInMain =
        		"1) Rent (Unknown) - ¥850.00\n" +
        		"2) Phone Bill (Bills) - ¥37.99\n" +
        		"3) Electricity Bill (Bills) - ¥75.00\n" +
        		"4) Sainsbury's Checkout (Groceries) - ¥23.76\n" +
        		"5) Tesco's Checkout (Groceries) - ¥7.24\n" +
        		"6) RockCity Drinks (Social) - ¥8.50\n" +
        		"7) The Mooch (Social) - ¥13.99\n";
        ListTransactionsSetInMain =
        		"1) Rent (Unknown) - ¥850.00\n";
        invalidNumberWrong = "Invalid number. Please input a valid number\n";
    }
    
    @AfterAll
    public static void tearDown() throws Exception
    {
        System.setProperty("line.separator", newLine);
        System.setIn(standardIn);
        System.setOut(standardOut);
    }
    
    @Test
    public void exit() throws Exception {
        assertIOStreamEquals(
            "X\n",
            overviewCategorySetInMain + menu + exit
        );
    }   
    
    @Test
    public void overviewCategoryAndExit() throws Exception
    {
        assertIOStreamEquals(
            "O\nX\n",
            overviewCategorySetInMain + menu + overviewCategorySetInMain +
            menu + exit
        );
    }
    
    @Test
    public void overviewTransactionAndExit() throws Exception
    {
        assertIOStreamEquals(
            "T\nX\n",
            overviewCategorySetInMain + menu + overviewTransactionSetInMain +
            menu + exit
        );
    }
	
    @Test
    public void testListTransactionsForCategory1 () throws Exception {
    	assertIOStreamEquals(
                "1\nX\n",
           overviewCategorySetInMain + menu + ListTransactionsSetInMain +
                menu + exit
            );
    }
    
    @Test
    public void testListTransactionsForCategory2 () throws Exception {
    	assertIOStreamEquals(
                "-3\nX\n",overviewCategorySetInMain + menu + "Category not exist\n"+
                menu + exit
           
            );
    }
    
    @Test
    public void testListTransactionsForCategory3 () throws Exception {
    	assertIOStreamEquals(
                "1000\nX\n",overviewCategorySetInMain + menu + "Category not exist\n"+
                menu + exit
            );
    }
    
    @Test
    public void testWrongInput() throws Exception {
    	assertIOStreamEquals(
                "ddd\nX\n",overviewCategorySetInMain + menu + "Command not recognised\n"+
                        menu + exit
            );
    }
    
    @Test
    public void testAddTransaction() throws Exception {

     assertIOStreamEquals(
                "A\nWater Bill\ndje\n9.00\nrr\n-1\n100\n2\nX\n", overviewCategorySetInMain + menu + promptsInAddTransaction1 + 
                "Invalid number. Please input a valid number\n" + "What is the value of the transaction?\n" + 
                overviewCategorySetInMain + "What category do you want to add?\nInvalid number. Please input a valid integer\n" + 
                overviewCategorySetInMain + "What category do you want to add?\nInvalid number. Category not exist\n"
                +  overviewCategorySetInMain + "What category do you want to add?\nInvalid number. Category not exist\n"
                +  overviewCategorySetInMain +  promptsInAddTransaction2 +
                menu + exit
           
            );
    }
    
    @Test
    public void testAddCategory1 () throws Exception {
    	assertIOStreamEquals(
                "N\nabcdefghijklmnopqrst\nabc\naaa\n20.00\nX\n",
                overviewCategorySetInMain + menu + promptsInAddCategory1 +
                "String too long\n"  + promptsInAddCategory1 + promptsInAddCategory2 +
                invalidNumberWrong + promptsInAddCategory2 + "[Category added]\n" +
                overviewCategorySetInMain + 
                "5) [abc](Budget: ¥20.00) - ¥0.00 (¥20.00 Remaining)\n"
                + menu + exit
            );
    }
    
    @Test
    public void ChangeTransactionCategoryTest() throws Exception {

     assertIOStreamEquals(
                "C\naa\n-2\n100\n2\naa\n-2\n100\n1\nX\n", overviewCategorySetInMain + menu + overviewTransactionSetInMain +
                "Which transaction ID?\nInvalid number. Please input a valid integer\n" + overviewTransactionSetInMain +
                "Which transaction ID?\nInvalid number. Transaction not exist\n" + overviewTransactionSetInMain +
                "Which transaction ID?\nInvalid number. Transaction not exist\n" + overviewTransactionSetInMain +
                "Which transaction ID?\n" + "\t- " + BoCApp.UserTransactions.get(1).toString() + "\n"  + 
                overviewCategorySetInMain +
                "What category do you want to add?\nInvalid number. Please input a valid integer\n" + overviewCategorySetInMain +
                "What category do you want to add?\nInvalid number. Category not exist\n" + overviewCategorySetInMain +
                "What category do you want to add?\nInvalid number. Category not exist\n" + overviewCategorySetInMain +
                "What category do you want to add?\n" + "[Unknown](Budget: ¥0.00) - ¥887.99 (¥887.99 Overspent)\n" +
                "[Bills](Budget: ¥120.00) - ¥75.00 (¥45.00 Remaining)\n" +
                menu + exit
           
            );
    }
    
    @Test
    public void testAll() throws Exception {

     assertIOStreamEquals(
                "T\nO\nN\nnewCat\n10.00\nA\nnewTran\n5.00\n5\nT\nO\nC\n8\n1\nT\nO\nX\n", 
                overviewCategorySetInMain + menu + overviewTransactionSetInMain + menu +overviewCategorySetInMain +menu +
                promptsInAddCategory1 +  promptsInAddCategory2 + "[Category added]\n" + overviewCategorySetInMain + "5) [newCat](Budget: ¥10.00) - ¥0.00 (¥10.00 Remaining)\n" +menu +
                promptsInAddTransaction1 + overviewCategorySetInMain + "5) [newCat](Budget: ¥10.00) - ¥0.00 (¥10.00 Remaining)\n" +
                "What category do you want to add?\n" + "[newTran](¥5.00) was added to [newCat]\n" +menu +
                overviewTransactionSetInMain + "8) newTran (newCat) - ¥5.00\n" + menu +overviewCategorySetInMain + "5) [newCat](Budget: ¥10.00) - ¥5.00 (¥5.00 Remaining)\n" +menu +
                overviewTransactionSetInMain + "8) newTran (newCat) - ¥5.00\n" +
                promptsInChangeTransactionCategory1 + "\t- " + "newTran - ¥5.00 date: "+ BoCApp.UserTransactions.get(5).transactionTime() + "\n"  +overviewCategorySetInMain + "5) [newCat](Budget: ¥10.00) - ¥5.00 (¥5.00 Remaining)\n" + "What category do you want to add?\n" + 
                "[Unknown](Budget: ¥0.00) - ¥855.00 (¥855.00 Overspent)\n" +
                "[newCat](Budget: ¥10.00) - ¥0.00 (¥10.00 Remaining)\n" + menu +
                overviewTransactionSetInMain + "8) newTran (Unknown) - ¥5.00\n" + menu +
                "1) [Unknown](Budget: ¥0.00) - ¥855.00 (¥855.00 Overspent)\n" +
        		"2) [Bills](Budget: ¥120.00) - ¥112.99 (¥7.01 Remaining)\n" +
        		"3) [Groceries](Budget: ¥75.00) - ¥31.00 (¥44.00 Remaining)\n" +
        		"4) [Social](Budget: ¥100.00) - ¥22.49 (¥77.51 Remaining)\n" + 
        		"5) [newCat](Budget: ¥10.00) - ¥0.00 (¥10.00 Remaining)\n" +
                menu + exit
           
           );
    }
    
    
	private void assertIOStreamEquals(String consoleIn, String expectedOut) throws Exception {

        InputStream inStream = new ByteArrayInputStream(consoleIn.getBytes());
        OutputStream outStream = new ByteArrayOutputStream();
        PrintStream outPrint = new PrintStream(outStream);

        // redirect test user input to standard input
        System.setIn(inStream);
        // redirect standard output to our PrintStream
        System.setOut(outPrint);

        // run the main method to get the actually output
        BoCApp.main(new String[0]);

        assertEquals(expectedOut, outStream.toString());
        ((ByteArrayOutputStream) outStream).reset();
	}
	

}
