<?php

namespace EasyAnalytics;

class Factory
{

    private static $firstNameWords = array(
        "John",
        "Jane",
        "Michael",
        "Emily",
        "William",
        "Olivia",
        "James",
        "Sophia",
        "Robert",
        "Ava",
        "David",
        "Isabella",
        "Joseph",
        "Mia",
        "Thomas",
        "Charlotte",
        "Charles",
        "Amelia",
        "Christopher",
        "Harper"
    );

    private static $lastNameWords = array(
        "Smith",
        "Johnson",
        "Williams",
        "Brown",
        "Jones",
        "Garcia",
        "Miller",
        "Davis",
        "Martinez",
        "Hernandez",
        "Lopez",
        "Gonzalez",
        "Wilson",
        "Anderson",
        "Thomas",
        "Jackson",
        "White",
        "Harris",
        "Martin",
        "Thompson"
    );



    /**
     * Makes an example entry for the Page View Log Table
     * @return array
     */
    function generateFakePageView()
    {
        return array(
            'page_id' => random_int(1, 100),
            'view_count' => random_int(1, 1000),
            'last_viewed' => $this->generateFakeDate(2000, 2024)
        );
    }

    /**
     * Makes an example entry for how well a page is doing in the analytics.
     * @return array
     */
    function generateFakePageAnalytics()
    {
        return array(
            'page_id' => random_int(1, 100),
            'time_on_page' => rand(10, 10000) / 1000,
            'bounce_rate' => rand(0, 9999) / 100
        );
    }

    /**
     * Make an example entry for users interacting on the page
     * @return array
     */
    function generateFakeUserInteraction()
    {
        return array(
            'page_id' => random_int(1, 100),
            'user_action' => $this->generateFakeAction(),
        );
    }

    /**
     * Generates a fake date by taking in two different year values, startYear being the earlier year. 
     * Made to give an example date in a YYYY-MM-DD format.
     * @param mixed $startYear - The earlier year
     * @param mixed $endYear   - The later year
     * @return string
     */
    function generateFakeDate($startYear, $endYear)
    {
        $startDate = new \DateTime("$startYear-01-01");
        $endDate = new \DateTime("$endYear-12-31");

        $interval = $endDate->diff($startDate);

        $totalDays = $interval->days;

        $randomDay = rand(0, $totalDays);
        $randomDate = $startDate->add(new \DateInterval("P{$randomDay}D"));

        return $randomDate->format('Y-m-d');
    }

    /**
     * Returns an example email.
     * @return string
     */
    function generateFakeEmail(): string
    {
        $firstName = $this->firstNameWords[array_rand($this->firstNameWords)];
        $lastName = $this->lastNameWords[array_rand($this->lastNameWords)];
        $domains = array("example.com", "xyz.com", "test.com");
        $domain = $domains[array_rand($domains)];
        $email = $firstName . '.' . $lastName . '@' . $domain;

        return $email;
    }

    /**
     * Returns a example name.
     * @return string
     */
    function generateFakeName(): string
    {
        $firstName = $this->firstNameWords[array_rand($this->firstNameWords)];
        $lastName = $this->lastNameWords[array_rand($this->lastNameWords)];
        $fakeName = $firstName . ' ' . $lastName;
        return $fakeName;
    }


    /**
     * Generates a fake action the user took.
     * @return string
     */
    function generateFakeAction()
    {
        $actions = array("clickedModal", "clickedImage", "ctaHit", "exit");
        $action = $actions[array_rand($actions)];

        return $action;
    }


}