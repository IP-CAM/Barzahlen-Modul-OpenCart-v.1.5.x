package de.barzahlen.shopmodules.opencart.selenium.pages.shop;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.PageFactory;

public class ShopHomePage extends ShopPage {

    public ShopHomePage(WebDriver driver) {
        super(driver);
    }

    public static ShopHomePage navigateTo(WebDriver driver) {
        driver.get("http://opencart.ubuntu-web-1");
        return PageFactory.initElements(driver, ShopHomePage.class);
    }

    public ShopProductDetailsPage selectProduct(int productId) {
        WebElement selectProduct = driver.findElement(By.xpath("//a[contains(@href, '/index.php?route=product/product&product_id=" + productId +"')]"));

        if (selectProduct != null) {
            selectProduct.click();
        }

        return PageFactory.initElements(driver, ShopProductDetailsPage.class);
    }
}
