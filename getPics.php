<?php

    class getImg {

        function __construct($url = 'http://blog.csdn.net/wang_jingxiang/article/details/4864705') {

            $ret = $this->setRequest($url);

            $total = $this->image($ret);

            foreach($total as $pic) {
                $this->savePics($pic);
            }
        }

        public function image($url) {

            preg_match_all("/<img([^>]*)\s*src=('|\")([^'\"]+)('|\")/", $url,$matches);//带引号
            //preg_match_all("/<img([^>]*)\ssrc=([^\s>]+)/",$string,$matches);//不带引号
            $matches=array_unique($matches[0]);//去除数组中重复的值

            foreach($matches as $key=>$val) {
                $matches[$key] = $this->stringSolve($val);
            }

            return $matches;

        }

        public function stringSolve($str) {
            $pos1 = stripos($str, '"');
            $pos2 = stripos($str, '"', $pos1+2);

            $str = substr($str, $pos1+1, $pos2-10);
            return $str;
        }

        public function savePics($pic) {
            $rt = $this->setRequest($pic);
            $fp = fopen('pics'.'/'.md5($pic).'.jpg', 'a');
            fwrite($fp, $rt);
            fclose($fp);
        }

        public function setRequest($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $ret = curl_exec($ch);
            curl_close($ch);
            return $ret;
        }

    }

    $test = new getImg;



?>