package de.barzahlen.shopmodules.opencart.selenium.pages.shop;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public class ShopCheckoutBarzahlenPage extends ShopPage{

    @FindBy(xpath="//div[@class='content']/div/div/p[1]")
    private WebElement headline;

    public ShopCheckoutBarzahlenPage(WebDriver driver) {
        super(driver);
    }

    public String getHeadline() {
        return headline.getText();
    }
}
