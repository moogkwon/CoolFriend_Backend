<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Home Controller
 * Management all actions before login.
 * 
 * @author yakov
 */


if (!function_exists('campaign_data')) {

    define("C_TABS", array(
        "Telegram",
        "Twitter",
        "Reddit",
        "Linkedin",
        "Bitcointalk",
		"Medium",
		"Writing Articles"
    ));
    /**
     * score: 
     * text:
     * url:
     * count: if canRepeat is true, this is max count in daily.
     *          if not, this value is not used.
     * canRepeat: can submit over twices.
     * comment: can show comment
     */
    define("C_DATA", array(
        array(
            "tab_id"=> 0,
            "score" => 50,
            "text"  => "Join our Telegram group",
            "url"   => "https://t.me/SocialRemit",
            "count" => 1,
            "canRepeat" => false,
            "comment"   => true
        ),
        array(
            "tab_id"=> 1,
            'score'=>50,
            'text'=>'Follow us on Twitter',
            'url'=>'https://twitter.com/Socialremit_uk',
            "count" => 1,
            "canRepeat" => false,
            "comment"   => true
        ),
        array(
            "tab_id"=> 1,
            'score'=>100,
            'text'=>'Like and Retweet',
            'url'=>'https://twitter.com/Socialremit_uk',
            "count" => 3,
            "canRepeat" => true,
            "comment"   => true
        ),
        array(
            "tab_id"=> 2,
            'score'=>50,
            'text'=>'Subscribe Our Reddit Account',
            'url'=>'https://www.reddit.com/r/blockchainio/comments/8fbgzo/welcome_to_the_internet_of_value/',
            "count" => 1,
            "canRepeat" => false,
            "comment"   => true
        ),
        array(
            "tab_id"=> 2,
            'id'=>6,
            'score'=>500,
            'text'=>'Comment and upvote this Reddit post',
            'url'=>'https://www.reddit.com/user/socialremit/posts/',
            "count" => 3,
            "canRepeat" => true,
            "comment"   => true
        ),
        array(
            "tab_id"=> 3,
            'score'=>50,
            'text'=>'Follow us on LikedIn',
            'url'=>'https://www.linkedin.com/company/SocialRemit/',
            "count" => 1,
            "canRepeat" => false,
            "comment"   => true
        ),
        array(
            "tab_id"=> 4,
            'score'=>50,
            'text'=>'Comment our Bitcointalk',
            'url'=>'https://bitcointalk.org/index.php?action=profile;u=1289972',
            "count" => 3,
            "canRepeat" => true,
            "comment"   => true
        ),
        array(
            "tab_id"=> 6,
            'score'=>500,
            'text'=>'Writing articles',
            'url'=>'https://t.me/Blockchain_io',
            "count" => 5,
            "canRepeat" => true,
            "comment"   => true
		),
		array(
            "tab_id"=> 5,
            'score'=>50,
            'text'=>'Medium',
            'url'=>'https://medium.com/@SocialRemit',
            "count" => 1,
            "canRepeat" => false,
            "comment"   => true
		),
		
        // array(
        //     "tab_id"=> 0,
        //     'score'=>500,
        //     'text'=>'Join our Telegram discussion channel',
        //     'url'=>'https://t.me/SocialRemit',
        //     "count" => 1,
        //     "canRepeat" => false,
        //     "comment"   => true
        // ),
    ));

    function getCampaignTab() {
        return C_TABS;
    }
    function getCampaignData() {
        return C_DATA;
    }

    function getCampaignTextWithId($id) {
        return C_DATA [$id]["text"];
    }

    function getCampaignCountDesc($count, $canRepeat) {
        if ($canRepeat)
            return "You can do this <label class='bold m-0 text-primary'>$count</label> times every day.";
        else
            return "One Time.";
    }
}
