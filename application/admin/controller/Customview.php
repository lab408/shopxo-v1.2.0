<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2018 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\service\CustomViewService;

/**
 * 自定义页面管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CustomView extends Common
{
	/**
	 * 构造方法
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:39:08+0800
	 */
	public function __construct()
	{
		// 调用父类前置方法
		parent::__construct();

		// 登录校验
		$this->Is_Login();

		// 权限校验
		$this->Is_Power();
	}

	/**
     * [Index 文章列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 参数
        $params = input();

        // 分页
        $number = 10;

        // 条件
        $where = CustomViewService::CustomViewListWhere($params);

        // 获取总数
        $total = CustomViewService::CustomViewTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/customview/index'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
            'field'     => '*',
        );
        $data = CustomViewService::CustomViewList($data_params);
        $this->assign('data_list', $data['data']);

		// 是否启用
		$this->assign('common_is_enable_list', lang('common_is_enable_list'));

		// 是否包含头部
		$this->assign('common_is_header_list', lang('common_is_header_list'));

		// 是否包含尾部
		$this->assign('common_is_footer_list', lang('common_is_footer_list'));

		// 是否满屏
		$this->assign('common_is_full_screen_list', lang('common_is_full_screen_list'));

		// 参数
        $this->assign('params', $params);
        return $this->fetch();
	}

	/**
	 * [SaveInfo 添加/编辑页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 参数
		$params = input();

		// 数据
		if(!empty($params['id']))
		{
			// 获取列表
	        $data_params = array(
	            'm'        => 0,
	            'n'        => 1,
	            'where'    => ['id'=>intval($params['id'])],
	            'field'    => '*',
	        );
	        $data = CustomViewService::CustomViewList($data_params);
	        $this->assign('data', empty($data['data'][0]) ? [] : $data['data'][0]);
		}

		// 是否启用
		$this->assign('common_is_enable_list', lang('common_is_enable_list'));

		// 是否包含头部
		$this->assign('common_is_header_list', lang('common_is_header_list'));

		// 是否包含尾部
		$this->assign('common_is_footer_list', lang('common_is_footer_list'));

		// 是否满屏
		$this->assign('common_is_full_screen_list', lang('common_is_full_screen_list'));

		return $this->fetch();
	}

	/**
	 * [Save 添加/编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function Save()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        return CustomViewService::CustomViewSave($params);
	}

	/**
	 * [Delete 删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-15T11:03:30+0800
	 */
	public function Delete()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['user_type'] = 'admin';
        return CustomViewService::CustomViewDelete($params);
	}

	/**
	 * [StatusUpdate 状态更新]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-12T22:23:06+0800
	 */
	public function StatusUpdate()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        return CustomViewService::CustomViewStatusUpdate($params);
	}
}
?>