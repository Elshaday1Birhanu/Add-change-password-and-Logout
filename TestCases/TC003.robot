*** Settings ***
Library     SeleniumLibrary


*** Variables ***
${URL}  https://www.google.com/
${browser}  chrome
*** Test Cases ***
to open the browser
    open browser    ${URL}  ${browser}
    input text  xpath://*[@id="APjFqb"] ethioprogramming
    click button    xpath:/html/body/div[1]/div[3]/form/div[1]/div[1]/div[3]/center/input[1]
    close browser
*** Keywords ***
