<?php

// 邮件列表管理,显示数据与更新
class EmgrAction extends Action {
	// 用于数据提交的表单门, 公共视图
	public function index() {
		$this->display ();
	}
	
	// 用于显示对应邮件的公共视图
	public function showlist() {
		$this->display ();
	}
	
	// 添加新邮箱
	public function addemail() {
		if (IS_POST) {
			header ( "Content-type:text/html;charset=utf-8" );
			$edmlist = M ( 'edm_email_list' );
			$list = $this->_post ( 'list' );
			$emails = explode ( "\n", $list );
			foreach ( $emails as $email ) {
				$email = trim ( $email );
				$data ['email'] = $email;
				if ($edmlist->data ( $data )->add ()) {
					echo '添加 ' . $email . ' 成功<br/>';
				} else {
					echo '添加 ' . $email . ' 失败<br/>';
				}
			}
		} else {
			$this->title = '添加邮箱';
			$this->display ( 'index' );
		}
	}
	
	// 提交退订邮箱
	public function unscribe() {
		$data ['unscribe'] = 1;
		$this->make_change ( $data, '更新退订' );
	}
	
	// 提交打开过的邮件列表
	public function open() {
		$data ['opcount'] = 1;
		$this->make_change ( $data, '更新打开' );
	}
	
	// 更新回复过的邮箱
	public function reply() {
		$data ['reply'] = 1;
		$this->make_change ( $data, '更新回复列表' );
	}
	
	// 更新自动回复的邮箱
	public function autoReply() {
		$data ['auto_reply'] = 1;
		$this->make_change ( $data, '更新自动回复' );
	}
	
	// 更新退订的邮箱
	public function reject() {
		$data ['auto_reply'] = 1;
		$this->make_change ( $data, '退订' );
	}
	
	// 显示打开过的邮箱
	public function showreply() {
		$condition = 'reply>0';
		$this->showall ( $condition, '打开过的邮件列表' );
	}
	
	// 显示退订的列表
	public function showunscribe() {
		$condition = 'unscribe>0';
		$this->showall ( $condition, '退订列表' );
	}
	// 显示退订信息
	public function show_reject() {
		$condition = 'reject>0';
		$this->showall ( $condition, '反弹退信列表' );
	}
	public function show_auto_reply() {
		$condition = 'auto_reply>0';
		$this->showall ( $condition, '反弹退信列表' );
	}
	
	// 获取符合条件的邮件列表
	public function getemailist() {
		$countsend = $this->_post ( 'countsend' );
		$countop = $this->_post ( 'countop' );
		$reply = $this->_post ( 'reply' );
		$limit = $this->_post ( 'limit' );
		
		$Eul = M ( 'edm_email_list' );
		$condition = 'send_count=' . $countsend . ' and opcount>=' . $countop . '  and reply=' . $reply . ' and unscribe=0 and reject=0 and auto_reply=0';
		$row = $Eul->limit ( $limit )->field ( 'email' )->where ( $condition )->select ();
		$emails = '';
		foreach ( $row as $email ) {
			$emails = $emails . $email ['email'] . ',';
		}
		
		// echo $emails;
		$this->ajaxReturn ( $emails, 'JSON' );
	}
	
	// 私用方法, 用户处理提交数据并显示公用的数据提交视图
	private function make_change($data, $title) {
		if (IS_POST) {
			header ( "Content-type:text/html;charset=utf-8" );
			$data ['send_count'] = 1;
			$data ['send_success'] = 1;
			$edmlist = M ( 'edm_email_list' );
			$list = $this->_post ( 'list' );
			$emails = explode ( "\n", $list );
			foreach ( $emails as $email ) {
				$email = trim ( $email );
				$edata ['email'] = $email;
				$condition = 'email="' . $email . '"';
				
				// 如果邮箱不存在则题添加到表中, 并更新发送以及传入的条件
				if ($edmlist->add ( $edata )) {
					echo '邮箱不存在进行添加' . $email . '<br/>';
				}
				$edmlist->where ( $condition )->save ( $data );
			}
		} else {
			$this->title = $title;
			$this->display ( 'index' );
		}
	}
	
	// 私有方法, 用于调用公用的显示模板
	private function showall($condition, $title) {
		$edm = M ( 'edm_email_list' ); // 实例化edm_email_list类
		import ( 'ORG.Util.Page' ); // 导入分页类
		$this->title = $title;
		$count = $edm->where ( $condition )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, 20 ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		$list = $edm->where ( $condition )->limit ( $Page->firstRow . ',' . $Page->listRows )->order ( 'id desc' )->select ();
		
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'show', $show ); // 赋值分页输出
		$this->display ( 'showlist' );
	}
}