import static org.junit.jupiter.api.Assertions.*;

import java.math.BigDecimal;
import java.util.Date;

import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.MethodOrderer;
import org.junit.jupiter.api.Order;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.TestMethodOrder;

import org.junit.Ignore;

@TestMethodOrder(MethodOrderer.OrderAnnotation.class)
class BoCTransactionTest {
	
	
	private static String tName,tName2,tName3,tName4,tName5;
	private static BigDecimal tValue,tValue2,tValue3,tValue4;
	private static int tCat,tCat2,tCat3;
	private static Date tTime;
	private static BoCTransaction transaction1;
	private static BoCTransaction transaction2;
	private static BoCTransaction transaction3;
	
	@BeforeAll
	static void setup() {
		tName = "testName";
		tName2 = "changedName";
		tName3 = null;
		tName4 = "aNameOver25WordsWhichShouldBeInvalid";
		tName5 = "aNameOver25WordsWhichShou";
		tValue = new BigDecimal("850.00");
		tValue2 = new BigDecimal("800.00");
		tValue3 = new BigDecimal("-800.00");
		tValue4 = null;
		tCat = 1;
		tCat2 = 2;
		tCat3 = -3;
		transaction3 = new BoCTransaction(tName,tValue,tCat);
	
		System.out.println("initial successful");
	}
	
	@Test
	@Order(1)
	void testBoCTransaction1() {
		transaction1 = new BoCTransaction();
		assertEquals(null, transaction1.transactionName());
		assertEquals(null, transaction1.transactionValue());
		assertEquals(null, transaction1.transactionTime());
		assertEquals(0, transaction1.transactionCategory());
		
	}
	
	@Test
	@Order(2)
	void testBoCTransaction2() {
		transaction2 = new BoCTransaction(tName,tValue,tCat);
		assertEquals(tName, transaction2.transactionName());
		assertEquals(tValue, transaction2.transactionValue());
		assertEquals(new Date(), transaction2.transactionTime());
		assertEquals(tCat, transaction2.transactionCategory());
	}
	
	@Test
	@Order(3)
	void testTransactionName() {
		assertEquals(tName, transaction3.transactionName());
	}

	@Test
	@Order(4)
	void testTransactionValue() {
		assertEquals(tValue, transaction3.transactionValue());
	}
	
	@Test
	@Order(5)
	void testTransactionCategory() {
		assertEquals(tCat, transaction3.transactionCategory());
	}
	
	@Test
	@Order(6)
	void testTransactionTime() {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
//		System.out.println(transaction.transactionTime().getTime() - tTime.getTime());
		tTime = new Date();
		assertEquals(transaction.transactionTime().getTime(), tTime.getTime(), 1000);
//		assertTrue("Dates aren't close enough to each other!", (transaction.transactionTime().getTime() - tTime.getTime()) < 1000);
	}

	@Test
	@Order(7)
	void testSetTransactionName1() throws Exception{
		BoCTransaction transaction = new BoCTransaction();
		transaction.setTransactionName(tName2);
		assertEquals(tName2, transaction.transactionName());
	}

	@Ignore //Old test without known exception
	void testSetTransactionName2Before() throws Exception{
		BoCTransaction transaction = new BoCTransaction();
		try {
			transaction.setTransactionName(tName3);
		} catch(Exception e) { 
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(8)
	void testSetTransactionName2() throws Exception{
		BoCTransaction transaction = new BoCTransaction();

		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionName(tName3);
		});
		assertEquals("Name cannot set to null", e.getMessage());
	}
	
	@Test
	@Order(9)
	void testSetTransactionName3() throws Exception{
		BoCTransaction transaction = new BoCTransaction();
		transaction.setTransactionName(tName4);
		assertEquals(tName5, transaction.transactionName());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionName4Before(){
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		try {
			transaction.setTransactionName(tName2);
		} catch(Exception e) { 
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(10)
	void testSetTransactionName4(){
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionName(tName2);
		});
		assertEquals("Name cannot be set", e.getMessage());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionName5Before(){
		BoCTransaction transaction = new BoCTransaction(tName,null,tCat);
		try {
			transaction.setTransactionName(tName2);
		} catch(Exception e) { 
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(11)
	void testSetTransactionName5(){
		BoCTransaction transaction = new BoCTransaction(tName,null,tCat);
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionName(tName2);
		});
		assertEquals("Name cannot be set", e.getMessage());

	}
	
	
	@Test
	@Order(13)
	void testSetTransactionValue1() throws Exception {
		BoCTransaction transaction = new BoCTransaction();
		transaction.setTransactionValue(tValue2);

		assertEquals(tValue2, transaction.transactionValue());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionValue2Before() {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		try {
			transaction.setTransactionValue(tValue2);
		} catch(Exception e) { 
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(14)
	void testSetTransactionValue2() {		
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionValue(tValue2);
		});
		assertEquals("Value cannot be set", e.getMessage());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionValue3Before() {
		BoCTransaction transaction = new BoCTransaction();
		try {
			transaction.setTransactionValue(tValue3); //-800
		} catch (Exception e) {
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(15)
	void testSetTransactionValue3() {
		BoCTransaction transaction = new BoCTransaction();
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionValue(tValue3);
		});
		assertEquals("Value should be positive", e.getMessage());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionValue4Before() {
		BoCTransaction transaction = new BoCTransaction();
		try {
			transaction.setTransactionValue(tValue4); //null
		} catch(Exception e) { 
			System.out.println(e.getMessage());
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(16)
	void testSetTransactionValue4() {
		
		BoCTransaction transaction = new BoCTransaction();
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionValue(tValue4);
		});
		assertEquals("Can not be set to null", e.getMessage());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionValue5Before() {
		BoCTransaction transaction = new BoCTransaction(null,tValue,tCat);
		try {
			transaction.setTransactionValue(tValue2);
		} catch(Exception e) { 
			return;
		}
	}
	
	@Test
	@Order(17)
	void testSetTransactionValue5() {
		BoCTransaction transaction = new BoCTransaction(null,tValue,tCat);
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionValue(tValue2);
		});
		assertEquals("Value cannot be set", e.getMessage());
	}
	
	@Test
	@Order(18)
	void testSetTransactionCategory1() throws Exception {
		BoCTransaction transaction = new BoCTransaction();
		transaction.setTransactionCategory(tCat);
		assertEquals(tCat, transaction.transactionCategory());
	}
	
	@Test
	@Order(19)
	void testSetTransactionCategory2() throws Exception {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		transaction.setTransactionCategory(tCat2);
		assertEquals(tCat2, transaction.transactionCategory());
	}
	
	@Ignore //Old test without known exception
	void testSetTransactionCategory3Before() {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		try {
			transaction.setTransactionCategory(tCat3);
		} catch(Exception e) { 
			return;
		}
		
		fail("It should have exception");
	}
	
	@Test
	@Order(20)
	void testSetTransactionCategory3() {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		Exception e = assertThrows(Exception.class, () -> {
			transaction.setTransactionCategory(tCat3);
		});
		assertEquals("Category cannot be negative", e.getMessage());
	}
	
	@Test
	@Order(21)
	void testIsComplete1() {
		BoCTransaction transaction = new BoCTransaction();
		assertEquals(0,transaction.isComplete());
	}
	
	@Test
	@Order(22)
	void testIsComplete2() {
		BoCTransaction transaction = new BoCTransaction(null,tValue,tCat);
		assertEquals(2,transaction.isComplete());
	}
	
	
	@Test
	@Order(23)
	void testIsComplete3() {
		BoCTransaction transaction = new BoCTransaction(tName,null,tCat);
		assertEquals(3,transaction.isComplete());
	}
	
	@Test
	@Order(24)
	void testIsComplete4() {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		assertEquals(1,transaction.isComplete());
	}


	@Test
	@Order(25)
	void testToString1() {
		BoCTransaction transaction = new BoCTransaction(tName,tValue,tCat);
		String nameString = transaction.transactionName(); 
		String valueString = transaction.transactionValue().toPlainString(); 
		String timeString = transaction.transactionTime().toString();
		String tranToString = nameString + " - ¥" + valueString + " date: " + timeString;
		assertEquals(tranToString,transaction.toString());
	}
	
	@Test
	@Order(26)
	void testToString2() {
		BoCTransaction transaction = new BoCTransaction(tName,null,tCat);
		String nameString = transaction.transactionName();  
		String timeString = transaction.transactionTime().toString();
		String tranToString = nameString + " - ¥" + " unset " + " date: " + timeString;
		assertEquals(tranToString,transaction.toString());
	}
	
	@Test
	@Order(27)
	void testToString3() {
		BoCTransaction transaction = new BoCTransaction(); 
		String tranToString = "unset" + " - ¥" + " unset " + " date: " + " unset ";
		assertEquals(tranToString,transaction.toString());
	}
	
	@Test
	@Order(28)
	void testToString4() {
		BoCTransaction transaction = new BoCTransaction(null, tValue, tCat); 
		String valueString = transaction.transactionValue().toPlainString(); 
		String timeString = transaction.transactionTime().toString();
		String tranToString = "unset" + " - ¥" + valueString + " date: " + timeString;
		assertEquals(tranToString,transaction.toString());
	}

}
