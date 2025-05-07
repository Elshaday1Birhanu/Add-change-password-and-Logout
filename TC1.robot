*** Settings ***
Library  SeleniumLibrary

*** Variables ***


*** Test Cases ***
LoginTest
    create webdrive IE  executable_path="C:\Drivers\IEDriverServer.exe"
    open broweser   C:\wamp64\www\web_project/ IE
    click link  xpath://button[@type='submit']
    input text  xpath://input[@type='text'] ethio
    input text  xpath://input[@type='password'] password@21E
    click element   xpath://button[@type='submit']
    close browser
*** Keywords ***