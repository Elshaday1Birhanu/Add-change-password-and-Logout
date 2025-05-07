*** Settings ***
Library     SeleniumLibrary



*** Variables ***
${URL}        https://tmptc.edu.et/
${browser}    chrome

*** Test Cases ***
InputBox
    Open Browser    ${URL}    ${browser}
    Maximize Browser Window
    input text  xpath://header/div[1]/div[2]/div[1]/div[1]/div[3]/div[1]/div[1]/form[1]/div[1]/input[1]  ethio
    click element    xpath://body[1]/div[1]/div[1]/header[1]/div[1]/div[2]/div[1]/div[1]/div[3]/div[1]/div[1]/form[1]/div[1]/button[1]/svg[1]/path[1]

    close browser

*** Keywords ***