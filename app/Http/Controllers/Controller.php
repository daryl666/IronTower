<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $pageCount = 2;

    protected $bill_outed = 1;
    protected $bill_not_out = 0;

    /**
     * 操作成功提示
     * @param $url string
     * @param $message 消息内容
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function success($url,$message)
    {
        Session::flash('message',$message);
        Session::flash('message_type',2);
        return redirect($url);
    }


    protected function error($url,$message)
    {
        Session::flash('message',$message);
        Session::flash('message_type',1);
        return redirect($url);
    }


    protected function showErrorMsg($url , $message){
        return view('errors.error')->with(compact('url','message'));
    }




    /**
     * 修改用户积分
     * @param $user_id 用户id
     * @param $action  执行动作：提问、回答、发起文章
     * @param int $source_id 源：问题id、回答id、文章id等
     * @param string $source_subject 源主题：问题标题、文章标题等
     * @param int $coins      金币数/财富值
     * @param int $credits    经验值
     * @return bool           操作成功返回true 否则  false
     */
    protected function credit($user_id,$action,$coins = 0,$credits = 0,$source_id = 0 ,$source_subject = null)
    {

    }

    /**
     * 记录用户动态
     * @param $user_id 动态发起人
     * @param $action  动作 ['ask','answer',...]
     * @param $source_id 问题或文章ID
     * @param $subject   问题或文章标题
     * @param string $content 回答或评论内容
     * @param int $refer_id  问题或者文章ID
     * @param int $refer_user_id 引用内容作者ID
     * @param null $refer_content 引用内容
     * @return static
     */
    protected function doing($user_id,$action,$source_type,$source_id,$subject,$content='',$refer_id=0,$refer_user_id=0,$refer_content=null)
    {

    }


    /**
     * 发送用户通知
     * @param $from_user_id
     * @param $to_user_id
     * @param $type
     * @param $subject
     * @param $source_id
     * @return static
     */
    protected function notify($from_user_id,$to_user_id,$type,$subject='',$source_id=0,$content='',$refer_type='',$refer_id=0)
    {

    }


    /**
     * 将通知设置为已读
     * @param $source_id
     * @param string $refer_type
     * @return mixed
     */
    protected function readNotifications($source_id,$refer_type='question')
    {

    }


    /*邮件发送*/
    protected function sendEmail($to_user_id,$type,$subject,$extData,$force=false){



    }
}
