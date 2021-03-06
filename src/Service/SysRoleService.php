<?php
/**
 * SysRole Service
 *
 * @author MR.Z << zsh2088@gmail.com >>
 * @version 2.0 2017-09-15
 */

namespace Smart\Service;

use Smart\Models\SysRole;

class SysRoleService extends BaseService {

	//引入 GridTable trait
	use \Smart\Traits\Service\GridTable,\Smart\Traits\Service\Instance;

	protected $model_class = SysRole::class;
	//状态
	var $status = [
		0 => '禁用',
		1 => '启用',
	];

	var $rank = [
		1 => '1级',
		2 => '2级',
		3 => '3级',
		4 => '4级',
		5 => '5级',
		6 => '6级',
		7 => '7级',
		8 => '8级',
		9 => '9级',
		10 => '10级',
	];

	var $mp_rank = [
		1 => '1级',
		2 => '2级',
		3 => '3级',
		4 => '4级',
		5 => '5级',
	];


	//生成类单例
	

	//取默认值
	function getDefaultRow() {
		return [
			'id' => '',
			'sort' => '99',
			'type' => 'backend',
			'mer_id' => '0',
			'name' => '',
			'status' => '1',
			'desc' => '',
			'expand' => '',
			'rank' => '1',
		];
	}

	//根据条件查询
	function getByCond($param) {
		$default = [
			'field' => '',
			'keyword' => '',
			'status' => '',
			'module' => 'backend',
			'page' => 1,
			'pageSize' => 10,
			'sort' => 'id',
			'order' => 'DESC',
			'count' => FALSE,
			'getAll' => FALSE,
		];

		$param = extend($default, $param);

		$model = $this->getModel()->keyword($param['keyword'])->module($param['module'])->status($param['status'])
			->where('rank', '<', 10);

		if ($param['count']) {
			return $model->count();
		} else {
			//     $this->getModel() = $this->getModel()->select( $param['field'] );
			$data = $model->getAll($param)
				->orderBy($param['order'], $param['sort'])->get()->toArray();

			return $data;

		}
	}

	/**
	 * 根据角色id获取角色信息
	 *
	 *
	 */
	function getById($id) {
		return $this->getModel()->find($id);
	}

	/**
	 * 根据模块获取角色
	 *
	 * @param $module
	 *
	 * @return mixed
	 */
	function getByModule($module) {

		$data = $this->getModel()
			->where('id', '<>', config('backend.superAdminId'))
			->module($module)
			->orderBy('rank', 'desc')
			->get()->toArray();

		return $data;
	}
}