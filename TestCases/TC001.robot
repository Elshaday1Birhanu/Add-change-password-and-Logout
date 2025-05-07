*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${URL}        http://www.aastu.edu.et/

*** Test Cases ***
User Registration
    [Documentation]    Test case for user open asstu website
    [Tags]    functional
    Open Browser    ${URL}    chrome

    Close Browser

*** Keywords ***