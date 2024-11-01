<?php
class IMDbapi {
    public $result = array('status'=>'false','message'=>'Unknown error');
    private $api_key = '';
    private $url = 'http://imdbapi.net/api';

    public function __construct($api = false)
    {
        $options = get_option( 'wp_imdb_api' );
        $this->api_key = @$options['imdbapi_field_apikey'];
    }

    public function get($id = false,$type = 'json')
    {
        $param = array(
            'body'=>array(
                'key'=>$this->api_key,
                'id'=>$id,
                'type'=>$type
            )
        );
        $response = wp_remote_post($this->url,$param);
        if(@$response['response']['code'] == 200){
            return wp_remote_retrieve_body($response);
        }
        else {
            return $this->result;
        }
    }

    public function title($title = false,$type = 'json')
    {
        $param = array(
            'body'=>array(
                'key'=>$this->api_key,
                'title'=>$title,
                'type'=>$type
            )
        );
        $response = wp_remote_post($this->url,$param);
        if(@$response['response']['code'] == 200){
            return wp_remote_retrieve_body($response);
        }
        else {
            return $this->result;
        }
    }

    public function search($keyword = '', $year = '',$page = 0,$type = 'json')
    {
        $param = array(
            'body'=>array(
                'key'=>$this->api_key,
                'title'=>$keyword,
                'year'=>$year,
                'page'=>$page,
                'type'=>$type
            )
        );
        $response = wp_remote_post($this->url,$param);
        if(@$response['response']['code'] == 200){
            return wp_remote_retrieve_body($response);
        }
        else {
            return $this->result;
        }
    }
}