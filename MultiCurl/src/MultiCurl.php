<?php

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/22
 * Time: 16:27
 */
class MultiCurl
{
    protected $master;
    /** @var MultiCurlItem[] $items */
    protected $items = [];

    public function __construct()
    {
        $this->master = curl_multi_init();
    }

    public function __destruct()
    {

        foreach ($this->items as $item) {
            curl_multi_remove_handle($this->master, $item->getHandle());
        }
        curl_multi_close($this->master);
    }

    public function get(MultiCurlItem $item)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $item->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 不直接输出
        curl_multi_add_handle($this->master, $ch);

        $item->setHandle($ch);
        $this->items[] = $item;

        return true;
    }


    /**
     * @return bool
     * @throws Exception
     */
    public function exec()
    {
        /** @var resource $mh curl句柄 */
        $mh = $this->master;

        /** @var int $still_running 仍然运行中的数量 */
        $still_running = 0;


        do {
            // 开始处理CURL上的子连接
            $mrc = curl_multi_exec($mh, $still_running);

        } while ($mrc == CURLM_CALL_MULTI_PERFORM);


        while ($still_running && $mrc == CURLM_OK) {

            // 等待socket信号
            if (curl_multi_select($mh) == -1) {
                usleep(100);
            }

            do {
                // 开始处理CURL上的子连接
                $mrc = curl_multi_exec($mh, $still_running);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            /*
            // TODO 进度输出
            foreach ($this->items as $item) {
                $l = curl_getinfo($item->getHandle(), CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                if ($l != -1) {
                    $p = curl_getinfo($item->getHandle(), CURLINFO_SIZE_DOWNLOAD);
                    var_dump($p . '/' . $l . ': ' . round($p / $l * 100, 2) . '%');
                }
            }
            */

            // 如果上面的信号有了，那这里就要一直拿数据。因为可能有1-N个请求响应完成
            while ($info = curl_multi_info_read($mh)) {
                if ($info["result"] == CURLE_OK) {
                    foreach ($this->items as $item) {
                        if ($item->getHandle() === $info['handle']) {
                            $item->callClosure();
                            break;
                        }
                    }
                } else {
                    throw new Exception(curl_error($info['handle']));
                }
            }


        }
        return true;
    }
}