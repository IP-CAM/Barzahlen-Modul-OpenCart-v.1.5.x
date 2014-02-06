package de.barzahlen.shopmodules.opencart.selenium;

import de.barzahlen.shopmodules.opencart.selenium.pages.shop.ShopCheckoutBarzahlenPage;
import de.barzahlen.shopmodules.opencart.selenium.pages.shop.ShopCheckoutPage;
import de.barzahlen.shopmodules.opencart.selenium.pages.shop.ShopHomePage;
import de.barzahlen.shopmodules.opencart.selenium.pages.shop.ShopProductDetailsPage;
import org.junit.Before;
import org.junit.After;
import org.junit.Ignore;
import org.junit.Test;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;

import java.net.URL;
import java.util.concurrent.TimeUnit;

import static org.junit.Assert.assertEquals;

public class CheckoutTest {
    private WebDriver driver;

    ShopHomePage homePage;
    ShopProductDetailsPage shopProductDetailsPage;
    ShopCheckoutPage checkoutPage;
    ShopCheckoutBarzahlenPage checkoutBarzahlenPage;

    @Before
    public void setUp() throws Exception {
        driver = null;
        homePage = null;
        shopProductDetailsPage = null;
        checkoutPage = null;
        checkoutBarzahlenPage = null;
    }

    @After
    public void tearDown() {
        if (driver != null) {
            driver.quit();
        }
    }

    @Test
    @Ignore // Ignore because the chrome driver has a bug
    public void testOrderWillBeTransferredToBarzahlenWithChrome() throws Exception {
        //DesiredCapabilities capability = DesiredCapabilities.chrome();
        //driver = new RemoteWebDriver(new URL("http://selenium:4444/wd/hub"), capability);
        driver = new ChromeDriver();
        driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
        testOrderWillBeTransferredToBarzahlen();
    }

    @Test
    public void testOrderWillBeTransferredToBarzahlenWithFirefox() throws Exception {
        //DesiredCapabilities capability = DesiredCapabilities.firefox();
        //driver = new RemoteWebDriver(new URL("http://selenium:4444/wd/hub"), capability);
        driver = new FirefoxDriver();
        driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
        testOrderWillBeTransferredToBarzahlen();
    }

    public void testOrderWillBeTransferredToBarzahlen() throws Exception {
        homePage = ShopHomePage.navigateTo(driver);
        homePage.selectCurrencyEuro();

        shopProductDetailsPage = homePage.selectProduct(43);
        shopProductDetailsPage.addProductToCart();

        checkoutPage = shopProductDetailsPage.navigateToCheckout();
        checkoutPage
            .selectCustomerTypeGuest()
            .continueToBillingDetails()

            .writeFirstName("foo")
            .writeLastName("bar")
            .writeEmail("foo@example.com")
            .writeTelephone("1234")
            .writeAddress1("street")
            .writeCity("Berlin")
            .writePostcode("12345")
            .selectCountry("Germany")
            .selectZone("Berlin")
            .continueToPaymentMethod()

            .selectPaymentMethodBarzahlen()
            .acceptTerms()
            .continueToConfirm();

        checkoutBarzahlenPage = checkoutPage
            .confirmOrder();

        assertEquals("Der finale Schritt zu Ihrem Produkt", checkoutBarzahlenPage.getHeadline());
    }
}
