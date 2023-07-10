<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_model extends CI_Model {

	
    public function getWebsiteStatsChart () {
        $range = $this->input->get('range');
        if($range == 'today') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else if($range == 'yesterday') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        }
 
        $sales = $this->getSales($date_range);
        $product_stocks = $this->getProductStocks();
        $product_orders = $this->getOrders($date_range);
        $net_sales = $this->getNetSales($date_range);
        $checked_in = $this->getActiveCheckIn();
        $service_offered = $this->getServices();


        $data['sales'] = $sales;
        $data['product_stocks'] = $product_stocks;
        $data['product_orders'] = $product_orders;
        $data['net_sales'] = $net_sales;
        $data['checked_in'] = $checked_in;
        $data['service_offered'] = $service_offered;

        return $data;
    }
    public function generateDateTime($range){
        $result = array();
        $timestamp = time();
        for ($i = 0 ; $i < $range ; $i++) {
            $array = array('date'=>date('d/m', $timestamp));
            $timestamp -= 24 * 3600;
        }
        array_push($result, $array);
        return $result;
    }
    public function getSales($date_range){
        $products = array();
            $query = $this->db->SELECT('SUM(total_sales) as sales')
                ->WHERE($date_range)
                ->WHERE('status','complete')
                ->GET('order_tbl')->row_array();
        $total_sales = '₱ '.number_format($query['sales'], 2);
        return $total_sales;
    }
    public function getNetSales($date_range){
        $products = array();
        $query = $this->db->SELECT('SUM(net_sales) as net')
            ->WHERE($date_range)
            ->WHERE('status','complete')
            ->GET('order_tbl')->row_array();
        $total_net = '₱ '.number_format($query['net'], 2);
        return $total_net;
    }
    public function getProductStocks(){
        $query = $this->db->SELECT('SUM(qty) as stocks')
            ->WHERE('status','active')
            ->GET('product_tbl')->row_array();
        return $query['stocks'];
    }
    public function getOrders($date_range){
        $products = array();
            $query = $this->db->WHERE($date_range)
                ->WHERE('status','complete')
                ->GET('order_tbl')->num_rows();
            return $query;
    }
    public function getActiveCheckIn(){
        $where = '(date_checked_in = "0000-00-00 00:00:00" AND date_checked_out = "0000-00-00 00:00:00" OR date_checked_out = "null")';
        $query = $this->db
            // ->WHERE('date_checked_in','')
            ->WHERE($where)
            // ->WHERE("(date_checked_in !== '0000-00-00 00:00:00' AND date_checked_out ==  OR dae_checked_out == ".null." )", NULL, FALSE)
            ->GET('boarding_tbl')->num_rows();
        return $query;
    }
    public function getServices(){
        $products = array();
            $query = $this->db->WHERE('status','active')
                ->GET('service_tbl')->num_rows();
            return $query;
    }
    
    public function mostSoldProducts(){
        $range = $this->input->get('range');
        if($range == 'today') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        }
        else if($range == 'yesterday') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        }
        else if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        }

		$groupBy = 'prod_id';
		$sold_products = $this->db->SELECT('SUM(pst.qty) as count, pst.prod_id, product_name')
            ->FROM('product_sales_tbl as pst')
            ->JOIN('product_tbl as pt','pt.prod_id=pst.prod_id')
			->WHERE($date_range)
			->GROUP_BY($groupBy)
            ->LIMIT(10)
			->ORDER_BY('count','desc')
			->GET()->result_array();

		$total_count = $this->db->SELECT('SUM(pst.qty) as total_count')
			->WHERE($date_range)
			->GET('product_sales_tbl as pst')->row_array();
            
		$result = array();
		foreach($sold_products as $q){
			
			$array = array(
				'count'=>$q['count'],
				'percentage' => round(($q['count'] / $total_count['total_count']) * 100, 2),
				'product_name'=>$q['product_name']
			);
			array_push($result, $array);
		}
		$data['statistics'] = $result;
		return $data;
    }

    public function mostSoldService(){
        $range = $this->input->get('range');
        if($range == 'today') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);
        }
        else if($range == 'yesterday') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);
        }
        else if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);
        }

		$groupBy = 'serv_id';
		$sold_products = $this->db->SELECT('COUNT(sst.serv_id) as count, sst.serv_id, service')
            ->FROM('service_sales_tbl as sst')
            ->JOIN('service_tbl as st','st.serv_id=sst.serv_id')
			->WHERE($date_range)
			->GROUP_BY($groupBy)
            ->LIMIT(10)
			->ORDER_BY('count','desc')
			->ORDER_BY('service','asc')
			->GET()->result_array();

		$total_count = $this->db->SELECT('COUNT(sst.serv_id) as total_count')
			->WHERE($date_range)
			->GET('service_sales_tbl as sst')->row_array();
            
		$result = array();
		foreach($sold_products as $q){
			
			$array = array(
				'count'=>$q['count'],
				'percentage' => round(($q['count'] / $total_count['total_count']) * 100, 2),
				'service'=>$q['service']
			);
			array_push($result, $array);
		}
		$data['statistics'] = $result;
		return $data;
    }
    public function productsByQty(){
        $range = $this->input->get('range');
        if($range == 'today') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('updated_at >'=>$start_date, 'updated_at <'=> $end_date);
        }
        else if($range == 'yesterday') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59', strtotime('-1 day', strtotime(date('Y-m-d 00:00:00'))));
            $date_range = array('updated_at >'=>$start_date, 'updated_at <'=> $end_date);
        }
        else if($range == '7_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-7 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('updated_at >'=>$start_date, 'updated_at <'=> $end_date);
        }

        else if($range == '15_days') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-15 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('updated_at >'=>$start_date, 'updated_at <'=> $end_date);
        }

        else if($range == '1_month') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('updated_at >'=>$start_date, 'updated_at <'=> $end_date);
        }
        else if($range == '1_year') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-365 day', strtotime(date('Y-m-d 00:00:00'))));
            $end_date = date('Y-m-d 23:59:59');
            $date_range = array('updated_at >'=>$start_date, 'updated_at <'=> $end_date);
        }

		$groupBy = 'prod_id';
		$sold_products = $this->db->SELECT('qty, product_name')
            ->FROM('product_tbl')
			->WHERE($date_range)
			->GROUP_BY($groupBy)
            ->LIMIT(10)
			->ORDER_BY('qty','desc')
			->ORDER_BY('product_name','asc')
			->GET()->result_array();

		$total_count = $this->db->SELECT('SUM(qty) as total_count')
			->WHERE($date_range)
			->GET('product_tbl')->row_array();
            
		$result = array();
		foreach($sold_products as $q){
			
			$array = array(
				'count'=>$q['qty'],
				'percentage' => round(($q['qty'] / $total_count['total_count']) * 100, 2),
				'product_name'=>$q['product_name']
			);
			array_push($result, $array);
		}
		$data['statistics'] = $result;
		return $data;
    }

    public function soldProductsOvertime($date_range){
        $groupBy = 'DATE(created_at)';
        $query = $this->db->SELECT('DATE(created_at) as date, COUNT(views_id) as views')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at','asc')
            ->GET('website_visits_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('d/m', strtotime($q['date'])),
                'views'=>$q['views']
            );
            array_push($result, $array);
        }
        return $result;
    }
}