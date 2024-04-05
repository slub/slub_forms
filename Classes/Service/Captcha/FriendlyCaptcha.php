<?php
namespace Slub\SlubForms\Service\Captcha;

use GuzzleHttp\Client;

class FriendlyCaptcha {

    CONST API_URL = 'https://api.friendlycaptcha.com/api/v1/siteverify';

    /**
     * This class represents the FriendlyCaptcha service for verifing CAPTCHA challenges.
     * 
     * @param string $solution
     * @param array $config
     * @return bool
     */
    public function verify(string $solution, $config = []) {

        if (!$solution) {
            return false;
        }

        $options = [
            'headers' => ['Cache-Control' => 'no-cache'],
            'allow_redirects' => true,
            'form_params' => [
                'secret' => $config['secret'],
                'sitekey' => $config['sitekey'],
                'solution' => $solution,
            ],
        ];

        $client = new Client();
        $contents = $client->request('POST', self::API_URL, $options);

        if (!$contents) {
            return false;
        }

        try {
            $result = json_decode($contents->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        } catch (\JsonException $e) {
            return false;
        }

        return (bool)$result->success;
    }

}