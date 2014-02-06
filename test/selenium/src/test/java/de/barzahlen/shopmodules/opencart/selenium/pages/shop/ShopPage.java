package de.barzahlen.shopmodules.opencart.selenium.pages.shop;

import de.barzahlen.shopmodules.opencart.selenium.pages.Page;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public abstract class ShopPage extends Page {

    @FindBy(linkText="€")
    private WebElement selectCurrencyEuro;

    public ShopPage(WebDriver driver) {
        super(driver);
    }

    public ShopPage selectCurrencyEuro() {
        waitForElementIsDisplayed(driver, selectCurrencyEuro);
        selectCurrencyEuro.click();
        return this;
    }
}
