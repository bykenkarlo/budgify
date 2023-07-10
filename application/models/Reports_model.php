<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {
    public function getProductList($row_per_page, $row_no){
        if (isset($this->session->admin)) {
            $search = $this->input->get('search');
            $query = $this->db->SELECT('pt.*, pct.name as category_name')
                 ->FROM('product_tbl as pt')
                 ->JOIN('product_category_tbl as pct', 'pct.prod_cat_id = pt.prod_cat_id','left')
                 ->WHERE("(pt.product_name LIKE '%".$search."%' OR pt.sku LIKE '%".$search."%' OR pct.name LIKE '%".$search."%' )", NULL, FALSE)
                 ->LIMIT($row_per_page, $row_no)
                 ->ORDER_BY('pt.created_at','desc')
                 ->GET()->result_array();
            $result = array();
        }
    }
	public function getMonthlySalesReports($row_per_page, $row_no) {
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $start_date = date('Y-m-d 00:00:00', strtotime($from));
        $end_date = date('Y-m-d 23:59:59', strtotime($to));
        $date_range = array('ot.created_at >'=>$start_date, 'ot.created_at <='=> $end_date);
        $total_sales = 0;

		$groupBy = 'DATE(ot.created_at)';
		$query = $this->db->SELECT('SUM(total_sales) as sales, SUM(ot.net_sales) as total_net_sales, srt.*, ot.created_at')
            ->FROM('order_tbl as ot')
            ->JOIN('sales_report_tbl as srt','srt.date = ot.date', 'left')
            ->WHERE("(ot.total_sales LIKE '%".$search."%' OR srt.remarks LIKE '%".$search."%' )", NULL, FALSE)
            ->WHERE($date_range)
			->GROUP_BY($groupBy)
            ->LIMIT($row_per_page, $row_no)
			->ORDER_BY('ot.created_at','desc')
			->GET()->result_array();

		$reports = array();
        $total_sales = 0;
        $meal_expense = 0;
        $office_cleaning_supp_expense = 0;
        $clinic_expense = 0;
        $grooming_expense = 0;
        $operating_expense = 0;
        $product_expense = 0;
        $others = 0;
        $daily_net_sales = 0;
        $total_net_sales = 0;
        $net_sales = 0;
		foreach($query as $q){
            $total_sales += $q['sales'];
            $daily_net_sales = $q['total_net_sales'] - ($q['meal_expense'] + $q['office_cleaning_supp_expense'] + $q['clinic_expense'] + $q['operating_expense'] + $q['product_expense'] + $q['others']);
            
            $total_net_sales += $daily_net_sales;
            $office_cleaning_supp_expense += $q['office_cleaning_supp_expense'];
            $meal_expense += $q['meal_expense'];
            $clinic_expense += $q['clinic_expense'];
            $grooming_expense += $q['grooming_expense'];
            $operating_expense += $q['operating_expense'];
            $product_expense += $q['product_expense'];
            $others += $q['others'];

            $daily_product_net_sales = $q['total_net_sales'];

			$array = array(
				'date'=>date('M d, Y', strtotime($q['created_at'])),
				'date_input'=>date('Y-m-d', strtotime($q['created_at'])),
				'gross_sales' => number_format($q['sales'],2),
				'net_sales' => number_format($q['total_net_sales'],2),
				'sales_input' => $q['sales'],
				'meal_expense' => $q['meal_expense'],
				'office_cleaning_supp_expense' => $q['office_cleaning_supp_expense'],
				'clinic_expense' => $q['clinic_expense'],
				'grooming_expense' => $q['grooming_expense'],
				'operating_expense' => $q['operating_expense'],
				'product_expense' => $q['product_expense'],
				'net_profit' => number_format($daily_net_sales,2),
				'others' => $q['others'],
				'remarks' => $q['remarks'],
			);
			array_push($reports, $array);
		}
        $result['total_sales'] = number_format($total_sales,2);
        $result['meal_expense'] = number_format($meal_expense,2);
        $result['office_cleaning_supp_expense'] = number_format($office_cleaning_supp_expense,2);
        $result['clinic_expense'] = number_format($clinic_expense,2);
        $result['grooming_expense'] = number_format($grooming_expense,2);
        $result['operating_expense'] = number_format($operating_expense,2);
        $result['product_expense'] = number_format($product_expense,2);
        $result['others'] = number_format($others,2);
        $result['net_sales'] = number_format($total_net_sales,2);
        $result['reports'] = $reports;
		return $result;
	}

    public function getMonthlySalesReportsCount() {
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        $start_date = date('Y-m-d 00:00:00', strtotime($from));
        $end_date = date('Y-m-d 23:59:59', strtotime($to));
        $date_range = array('ot.created_at >'=>$start_date, 'ot.created_at <'=> $end_date);
		$groupBy = 'DATE(ot.created_at)';
		return $this->db->FROM('order_tbl as ot')
            ->JOIN('sales_report_tbl as srt','srt.date = ot.date', 'left')
            ->WHERE("(ot.total_sales LIKE '%".$search."%' OR srt.remarks LIKE '%".$search."%')", NULL, FALSE)
            ->WHERE($date_range)
            ->WHERE('ot.status','complete')
			->GROUP_BY($groupBy)
			->ORDER_BY('ot.created_at','desc')
			->GET()->num_rows();
	}
    public function getClientSalesReports($row_per_page, $row_no) {
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        $start_date = date('Y-m-d 00:00:00', strtotime($from));
        $end_date = date('Y-m-d 23:59:59', strtotime($to));
        $date_range = array('ot.created_at >'=>$start_date, 'ot.created_at <'=> $end_date);

		$groupBy = 'ot.client_id';
		$reports = $this->db->SELECT('ot.payment_type, ot.reference_no, ot.created_at, ot.client_id, csrt.remarks')
            ->FROM('order_tbl as ot')
            ->JOIN('client_sales_remark_tbl as csrt','csrt.client_id=ot.client_id AND csrt.date = ot.date','left')
            ->JOIN('client_tbl as ct','ct.client_id=ot.client_id','left')
            ->JOIN('product_sales_tbl as pst','pst.reference_no=ot.reference_no','left')
            ->JOIN('product_tbl as pt','pt.prod_id=pst.prod_id','left')
            ->JOIN('service_sales_tbl as sst','sst.reference_no=ot.reference_no','left')
            ->JOIN('service_tbl as st','st.serv_id=sst.serv_id','left')
            ->WHERE("(ot.total_sales LIKE '%".$search."%' OR ct.name LIKE '%".$search."%' OR pt.product_name LIKE '%".$search."%' OR ot.reference_no LIKE '%".$search."%' OR st.service LIKE '%".$search."%')", NULL, FALSE)
            ->WHERE('ot.status','complete')
            ->WHERE($date_range)
			->GROUP_BY($groupBy)
            ->LIMIT($row_per_page, $row_no)
			->ORDER_BY('ot.created_at','desc')
			->GET()->result_array();
        $get_product = array();
        $get_boarding = array();
        $get_service = array();
		$result = array();
		foreach($reports as $q){
            $client_data = $this->db->SELECT('name')->WHERE('client_id',$q['client_id'])->GET('client_tbl')->row_array();
            $client_name = $client_data['name'];

            if($q['client_id'] <= 0){
                $client_name = 'Guest';
            }
            $date = date('Y-m-d', strtotime($q['created_at']));
            $total_sales = 0;
            $get_product = $this->getBoughtProducts($q['client_id'], $date);
            $get_service = $this->getBoughtService($q['client_id'], $date);
            $surgery_get = $this->getClientSurgery($q['client_id'], $date);
            $get_grooming = $this->getClientGrooming($q['client_id'], $date);
            $get_boarding = $this->getClientBoarding($q['client_id'], $date);
            $total_sales = $surgery_get['total_sales'] + $get_product['total_sales'] + $get_service['total_sales'] + $get_boarding['total_sales'] + $get_grooming['total_sales'];
			$array = array(
				'date'=>date('M d, Y', strtotime($q['created_at'])),
				'client_id'=>$q['client_id'],
				'client_name'=>$client_name,
				'surgery'=>$surgery_get['result'],
				'products'=>$get_product['result'],
				'service'=>$get_service['result'],
				'boarding'=>$get_boarding['result'],
				'grooming'=>$get_grooming['result'],
				'total_sales'=>'₱ '.number_format($total_sales,2),
				'remarks'=>$q['remarks'],
				'date_'=>$date,
			);
			array_push($result, $array);
		}
		return $result;
	}
    public function getBoughtProducts($client_id, $date) {
        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $end_date = date('Y-m-d 23:59:59', strtotime($date));
        $date_range = array('pst.created_at >'=>$start_date, 'pst.created_at <'=> $end_date);
        $total_sales = 0;
        $data = array();
        $query = $this->db->SELECT('pt.product_name, pst.price, pst.qty, pst.discount')
            ->FROM('order_tbl as ot')
            ->JOIN('product_sales_tbl as pst', 'pst.reference_no=ot.reference_no','left')
            ->JOIN('product_tbl as pt','pt.prod_id=pst.prod_id', 'left')
            ->WHERE('ot.client_id', $client_id)
            ->WHERE($date_range)
            ->GET()->result_array();
        
        foreach($query as $q){
            $amount = ($q['price'] * $q['qty']) - $q['discount'];
            $total_sales += $amount;
            $arr = array(
                'product'=>$q['product_name'].' - ₱'.number_format($amount,2),
            );
            array_push($data, $arr);
        }
        $result['result'] = $data;
        $result['total_sales'] = $total_sales;
        return $result;
    }
    public function getBoughtService($client_id, $date) {
        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $end_date = date('Y-m-d 23:59:59', strtotime($date));
        $date_range = array('sst.created_at >'=>$start_date, 'sst.created_at <'=> $end_date);

        $total_sales = 0;
        $data = array();
        $query = $this->db->SELECT('st.service, sst.price, sst.discount')
            ->FROM('order_tbl as ot')
            ->JOIN('service_sales_tbl as sst', 'sst.reference_no=ot.reference_no','left')
            ->JOIN('service_tbl as st','st.serv_id=sst.serv_id', 'left')
            ->WHERE('ot.client_id', $client_id)
            ->WHERE($date_range)
            ->GET()->result_array();
        
        foreach($query as $q){
            $amount = $q['price'] - $q['discount'];
            $total_sales += $amount;
            $arr = array(
                'service'=>$q['service'].' - ₱'.number_format($amount,2),
            );
            array_push($data, $arr);
        }
        $result['result'] = $data;
        $result['total_sales'] = $total_sales;
        return $result;
    }
    public function getClientSurgery($client_id, $date) {
        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $end_date = date('Y-m-d 23:59:59', strtotime($date));
        $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
        $total_sales = 0;
        $data = array();
        $query = $this->db->SELECT('surgery, pet_name, amount')
            ->WHERE('client_id', $client_id)
            ->WHERE($date_range)
            ->GET('surgery_tbl')->result_array();
        foreach($query as $q){
            $total_sales += $q['amount'];
            $arr = array(
                'surgery'=>$q['surgery'].' ('.$q['pet_name'].') '.' - ₱'.number_format($q['amount'],2),
            );
            array_push($data, $arr);
        }
        $result['result'] = $data;
        $result['total_sales'] = $total_sales;
        return $result;
    }
    public function getClientBoarding($client_id, $date) {
        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $end_date = date('Y-m-d 23:59:59', strtotime($date));
        $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);

        $total_sales = 0;
        $data = array();
        $query = $this->db->SELECT('pet_name, amount')
            ->WHERE('client_id', $client_id)
            ->WHERE($date_range)
            ->GET('boarding_tbl')->result_array();
        $total_sales = 0;
        foreach($query as $q){
            $total_sales += $q['amount'];
            $arr = array(
                'boarding'=>$q['pet_name'].' - ₱'.number_format($q['amount'],2),
            );
            array_push($data, $arr);
        }
        $result['result'] = $data;
        $result['total_sales'] = $total_sales;
        return $result;
    }

    public function getClientGrooming($client_id, $date) {
        $start_date = date('Y-m-d 00:00:00', strtotime($date));
        $end_date = date('Y-m-d 23:59:59', strtotime($date));
        $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);

        $total_sales = 0;
        $data = array();
        $query = $this->db->SELECT('pet_name, amount')
            ->WHERE('client_id', $client_id)
            ->WHERE($date_range)
            ->GET('grooming_tbl')->result_array();
        $total_sales = 0;
        foreach($query as $q){
            $total_sales += $q['amount'];
            $arr = array(
                'grooming'=>$q['pet_name'].' - ₱'.number_format($q['amount'],2),
            );
            array_push($data, $arr);
        }
        $result['result'] = $data;
        $result['total_sales'] = $total_sales;
        return $result;
    }
    public function getClientSalesReportsCount() {
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        $start_date = date('Y-m-d 00:00:00', strtotime($from));
        $end_date = date('Y-m-d 23:59:59', strtotime($to));
        $date_range = array('ot.created_at >'=>$start_date, 'ot.created_at <'=> $end_date);

		$groupBy = 'ot.client_id';
		return $this->db->SELECT('ot.payment_type, ot.reference_no, ot.created_at, ot.client_id, csrt.remarks')
            ->FROM('order_tbl as ot')
            ->JOIN('client_sales_remark_tbl as csrt','csrt.client_id=ot.client_id AND csrt.date = ot.date','left')
            ->WHERE("(ot.total_sales LIKE '%".$search."%')", NULL, FALSE)
            ->WHERE('ot.status','complete')
            ->WHERE($date_range)
			->GROUP_BY($groupBy)
			->ORDER_BY('ot.created_at','desc')
			->GET()->num_rows();
	}
    public function addSalesPerClientRemark() {
        $client_id = $this->input->post('client_id');
        $date = $this->input->post('date');
        $check = $this->db->WHERE('client_id',$client_id)->WHERE('date', $date)->GET('client_sales_remark_tbl')->row_array();
        if(empty($check)){
            $data_arr = array(
                'remarks'=>$this->input->post('remarks'),
                'client_id'=>$client_id,
                'date'=>$date,
            );
            $this->db->INSERT('client_sales_remark_tbl',$data_arr);
            $response['status'] = 'success';
            $response['message'] = 'Remarks added!';
            return $response;
        }
        else{
            $data_arr = array(
                'remarks'=>$this->input->post('remarks'),
            );
            $this->db->WHERE('client_id',$client_id)->WHERE('date', $date)->UPDATE('client_sales_remark_tbl',$data_arr);
            $response['status'] = 'success';
            $response['message'] = 'Remarks updated!';
            return $response;
        }
    }
    public function addDailyReports() {
        $date = $this->input->post('date');
        $daily_sales = $this->input->post('daily_sales');
        $meal = $this->input->post('meal');
        $office_supplies = $this->input->post('office_supplies');
        $clinic_expense = $this->input->post('clinic_expense');
        $grooming_expense = $this->input->post('grooming_expense');
        $operating = $this->input->post('operating');
        $product = $this->input->post('product');
        $remarks = str_replace(array('\'', '"'),'', $this->input->post('remarks'));
        $other = $this->input->post('other');

        $check = $this->db->WHERE('date', $date)->GET('sales_report_tbl')->row_array();
        $net_sales = 0;
        $net_sales = (float)$daily_sales - ((float)$meal + (float)$office_supplies + (float)$clinic_expense + (float)$operating + (float)$product + (float)$other);
        if(empty($check)){
            $data_arr = array(
                'meal_expense'=>$meal,
                'office_cleaning_supp_expense'=>$office_supplies,
                'clinic_expense'=>$clinic_expense,
                'grooming_expense'=>$grooming_expense,
                'operating_expense'=>$operating,
                'product_expense'=>$product,
                'remarks'=>$remarks,
                'net_sales'=>$net_sales,
                'others'=>$other,
                'date'=>$date,
            );
            $this->db->INSERT('sales_report_tbl',$data_arr);
            $response['status'] = 'success';
            $response['message'] = 'Daily Report added!';
            return $response;
        }
        else{
            $data_arr = array(
                'meal_expense'=>$meal,
                'office_cleaning_supp_expense'=>$office_supplies,
                'clinic_expense'=>$clinic_expense,
                'grooming_expense'=>$grooming_expense,
                'operating_expense'=>$operating,
                'product_expense'=>$product,
                'net_sales'=>$net_sales,
                'others'=>$other,
                'remarks'=>$remarks,
            );
            $this->db->WHERE('date', $date)->UPDATE('sales_report_tbl',$data_arr);
            $response['status'] = 'success';
            $response['message'] = 'Daily report updated!';
            return $response;
        }
    }
    public function getActivityLogs($row_per_page, $row_no) {
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $start_date = date('Y-m-d 00:00:00', strtotime($from));
        $end_date = date('Y-m-d 23:59:59', strtotime($to));
        $date_range = array('alt.created_at >'=>$start_date, 'alt.created_at <'=> $end_date);

        $result = array();
		$query = $this->db->SELECT('alt.user_id, message_log, browser, platform, ut.name, alt.created_at')
            ->FROM('activity_logs_tbl as alt')
            ->JOIN('users_tbl as ut','ut.user_id=alt.user_id')
            ->WHERE("(message_log LIKE '%".$search."%' OR ut.name LIKE '%".$search."%')", NULL, FALSE)
            ->WHERE($date_range)
            ->LIMIT($row_per_page, $row_no)
			->ORDER_BY('alt.created_at','desc')
			->GET()->result_array();

		foreach($query as $q){
			$array = array(
				'user' => $q['name'],
				'message_log' => $q['message_log'],
				'browser' => $q['browser'],
				'platform' => $q['platform'],
				'created_at' =>date('m/d/Y h:i A', strtotime( $q['created_at'])),
			);
			array_push($result, $array);
		}
      
		return $result;
    }
    public function getActivityLogsCount() {
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $start_date = date('Y-m-d 00:00:00', strtotime($from));
        $end_date = date('Y-m-d 23:59:59', strtotime($to));
        $date_range = array('alt.created_at >'=>$start_date, 'alt.created_at <'=> $end_date);

        return  $this->db->FROM('activity_logs_tbl as alt')
        ->JOIN('users_tbl as ut','ut.user_id=alt.user_id')
        ->WHERE("(message_log LIKE '%".$search."%' OR name LIKE '%".$search."%')", NULL, FALSE)
        ->WHERE($date_range)
        ->GET()->num_rows();
    }
    public function getDailyReportDataByDate() {
        $date = $this->input->get('date');

		$query = $this->db->FROM('sales_report_tbl as alt')
            ->WHERE('date', $date)
			->GET()->row_array();

		$result['date'] = $query['date'];
		$result['meal_expense'] = ($query['meal_expense']) ? $query['meal_expense'] : '0.00';
		$result['office_cleaning_supp_expense'] = ($query['office_cleaning_supp_expense']) ? $query['office_cleaning_supp_expense'] : '0.00';
		$result['clinic_expense'] = ($query['clinic_expense']) ? $query['clinic_expense'] : '0.00';
		$result['grooming_expense'] = ($query['grooming_expense']) ? $query['grooming_expense'] : '0.00';
		$result['operating_expense'] = ($query['operating_expense']) ? $query['operating_expense'] : '0.00';
		$result['product_expense'] = ($query['product_expense']) ? $query['product_expense'] : '0.00';
		$result['others'] = ($query['others']) ? $query['others'] : '0.00';
		$result['net_sales'] = ($query['net_sales']) ? $query['net_sales'] : '0.00';
		$result['remarks'] = ($query['remarks']) ? $query['remarks'] : '';
		return $result;
    }
}