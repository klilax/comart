<?php

const DB_SERVER = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "Pi@3.141";
const DB_NAME = "comart";

function getConnection() {
    try {
        return new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    } catch (PDOException $e) {
        die("ERROR: Could not connect. <br>" . $e->getMessage());
    }
}
