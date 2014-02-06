package de.barzahlen.shopmodules.opencart.selenium.pages.shop;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

public class ShopProductDetailsPage extends ShopPage {

    @FindBy(id="button-cart")
    private WebElement addToCartButton;

    @FindBy(linkText="Checkout")
    private WebElement checkoutLink;

    public static ShopProductDetailsPage navigateToProduct(WebDriver driver, int productId) {
        driver.get("http://opencart.ubuntu-web-1/index.php?route=product/product&product_id=" + productId);
        return PageFactory.initElements(driver, ShopProductDetailsPage.class);
    }

    public ShopProductDetailsPage(WebDriver driver) {
        super(driver);
    }

    public ShopProductDetailsPage addProductToCart() {
        waitForElementIsDisplayed(driver, addToCartButton);
        addToCartButton.click();
        return this;
    }

    public ShopCheckoutPage navigateToCheckout() {
        waitForElementIsDisplayed(driver, checkoutLink);
        checkoutLink.click();
        return PageFactory.initElements(driver, ShopCheckoutPage.class);
    }
}
