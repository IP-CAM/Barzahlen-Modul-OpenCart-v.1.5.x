package de.barzahlen.shopmodules.opencart.selenium.pages.shop;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.Select;

public class ShopCheckoutPage extends ShopPage{

    @FindBy(id="guest")
    WebElement customerTypeGuest;

    @FindBy(id="button-account")
    WebElement confirmCheckoutOptions;

    @FindBy(name="firstname")
    WebElement firstNameTextField;

    @FindBy(name="lastname")
    WebElement lastNameTextField;

    @FindBy(css="div.left > input[name=\"email\"]")
    WebElement emailTextField;

    @FindBy(name="telephone")
    WebElement telephoneTextField;

    @FindBy(name="address_1")
    WebElement address1TextField;

    @FindBy(name="city")
    WebElement cityTextField;

    @FindBy(name="postcode")
    WebElement postcodeTextField;

    @FindBy(name="country_id")
    WebElement countrySelect;

    @FindBy(name="zone_id")
    WebElement zoneSelect;

    @FindBy(id="button-guest")
    WebElement confirmBillingDetails;

    @FindBy(id="barzahlen")
    WebElement paymentMethodBarzahlen;

    @FindBy(name="agree")
    WebElement terms;

    @FindBy(id="button-payment-method")
    WebElement confirmPaymentMethod;

    @FindBy(id="button-confirm")
    WebElement confirmOrder;

    public ShopCheckoutPage(WebDriver driver) {
        super(driver);
    }

    public ShopCheckoutPage selectCustomerTypeGuest() {
        waitForElementIsDisplayed(driver, customerTypeGuest);
        customerTypeGuest.click();
        return this;
    }

    public ShopCheckoutPage continueToBillingDetails() {
        waitForElementIsDisplayed(driver, confirmCheckoutOptions);
        confirmCheckoutOptions.click();
        return this;
    }

    public ShopCheckoutPage writeFirstName(String firstName) {
        waitForElementIsDisplayed(driver, firstNameTextField);
        firstNameTextField.clear();
        firstNameTextField.sendKeys(firstName);
        return this;
    }

    public ShopCheckoutPage writeLastName(String lastName) {
        waitForElementIsDisplayed(driver, lastNameTextField);
        lastNameTextField.clear();
        lastNameTextField.sendKeys(lastName);
        return this;
    }

    public ShopCheckoutPage writeEmail(String email) {
        waitForElementIsDisplayed(driver, emailTextField);
        emailTextField.clear();
        emailTextField.sendKeys(email);
        return this;
    }

    public ShopCheckoutPage writeTelephone(String telephone) {
        waitForElementIsDisplayed(driver, telephoneTextField);
        telephoneTextField.clear();
        telephoneTextField.sendKeys(telephone);
        return this;
    }

    public ShopCheckoutPage writeAddress1(String address1) {
        waitForElementIsDisplayed(driver, address1TextField);
        address1TextField.clear();
        address1TextField.sendKeys(address1);
        return this;
    }

    public ShopCheckoutPage writeCity(String city) {
        waitForElementIsDisplayed(driver, cityTextField);
        cityTextField.clear();
        cityTextField.sendKeys(city);
        return this;
    }

    public ShopCheckoutPage writePostcode(String postcode) {
        waitForElementIsDisplayed(driver, postcodeTextField);
        postcodeTextField.clear();
        postcodeTextField.sendKeys(postcode);
        return this;
    }

    public ShopCheckoutPage selectCountry(String country) {
        waitForElementIsDisplayed(driver, countrySelect);
        new Select(countrySelect).selectByVisibleText(country);
        return this;
    }

    public ShopCheckoutPage selectZone(String zone) {
        waitForElementIsDisplayed(driver, zoneSelect);
        new Select(zoneSelect).selectByVisibleText(zone);
        return this;
    }

    public ShopCheckoutPage continueToPaymentMethod() {
        waitForElementIsDisplayed(driver, confirmBillingDetails);
        confirmBillingDetails.click();
        return this;
    }

    public ShopCheckoutPage selectPaymentMethodBarzahlen() {
        waitForElementIsDisplayed(driver, paymentMethodBarzahlen);
        paymentMethodBarzahlen.click();
        return this;
    }

    public ShopCheckoutPage acceptTerms() {
        waitForElementIsDisplayed(driver, terms);
        terms.click();
        return this;
    }

    public ShopCheckoutPage continueToConfirm() {
        waitForElementIsDisplayed(driver, confirmPaymentMethod);
        confirmPaymentMethod.click();
        return this;
    }

    public ShopCheckoutBarzahlenPage confirmOrder() {
        waitForElementIsDisplayed(driver, confirmOrder);
        confirmOrder.click();
        return PageFactory.initElements(driver, ShopCheckoutBarzahlenPage.class);
    }
}
