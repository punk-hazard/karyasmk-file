<?php
// Heading
$_['heading_title']           = 'Pengembalian Pembayaran';

// Text
$_['text_account']            = 'Akun';
$_['text_recurring']          = 'Informasi Pengembalian Pembayaran';
$_['text_recurring_detail']   = 'Detail Pengembalian Pembayaran';
$_['text_order_recurring_id'] = 'ID Pengembalian:';
$_['text_date_added']         = 'Tanggal Ditambahkan:';
$_['text_status']             = 'Status:';
$_['text_payment_method']     = 'Metode Pembayaran:';
$_['text_order_id']           = 'ID Pesanan:';
$_['text_product']            = 'Produk:';
$_['text_quantity']           = 'Jumlah:';
$_['text_description']        = 'Deskripsi';
$_['text_reference']          = 'Referensi';
$_['text_transaction']        = 'Transaksi';


$_['text_status_1']           = 'Aktif';
$_['text_status_2']           = 'Tidak Aktif';
$_['text_status_3']           = 'Dibatalkan';
$_['text_status_4']           = 'Dihentikan/Ditutup';
$_['text_status_5']           = 'Kadaluarsa';
$_['text_status_6']           = 'Ditunda';

$_['text_transaction_date_added'] = 'Buat';
$_['text_transaction_payment'] = 'Pembayaran';
$_['text_transaction_outstanding_payment'] = 'Pembayaran yang harus dipenuhi';
$_['text_transaction_skipped'] = 'Pembayaran Dilewatkan';
$_['text_transaction_failed'] = 'Pembayaran Gagal';
$_['text_transaction_cancelled'] = 'Dibatalkan';
$_['text_transaction_suspended'] = 'Dihentikan';
$_['text_transaction_suspended_failed'] = 'Dihentikan karena pembayaran gagal';
$_['text_transaction_outstanding_failed'] = 'Gagal melakukan pembayaran yang harus dipenuhi';
$_['text_transaction_expired'] = 'Kadaluarsa';




$_['text_empty']                 = 'Tidak ditemukan pengembalikan pembayaran!';
$_['text_error']                 = 'Pengembalian pesanan yang anda minta tidak dapat ditemukan!';








$_['text_cancelled'] = 'Recurring payment has been cancelled';

/*

		$data['status_types'] = array(
			1 => $this->language->get('text_status_inactive'),
			2 => $this->language->get('text_status_active'),
			3 => $this->language->get('text_status_suspended'),
			4 => $this->language->get('text_status_cancelled'),
			5 => $this->language->get('text_status_expired'),
			6 => $this->language->get('text_status_pending'),
		);

		$data['transaction_types'] = array(
			0 => $this->language->get('text_transaction_date_added'),
			1 => $this->language->get('text_transaction_payment'),
			2 => $this->language->get('text_transaction_outstanding_payment'),
			3 => $this->language->get('text_transaction_skipped'),
			4 => $this->language->get('text_transaction_failed'),
			5 => $this->language->get('text_transaction_cancelled'),
			6 => $this->language->get('text_transaction_suspended'),
			7 => $this->language->get('text_transaction_suspended_failed'),
			8 => $this->language->get('text_transaction_outstanding_failed'),
			9 => $this->language->get('text_transaction_expired'),
		);
		
			private $recurring_status = array(
		0 => 'Inactive',
		1 => 'Active',
		2 => 'Suspended',
		3 => 'Cancelled',
		4 => 'Expired / Complete'
	);

	private $transaction_type = array(
		0 => 'Created',
		1 => 'Payment',
		2 => 'Outstanding payment',
		3 => 'Payment skipped',
		4 => 'Payment failed',
		5 => 'Cancelled',
		6 => 'Suspended',
		7 => 'Suspended from failed payment',
		8 => 'Outstanding payment failed',
		9 => 'Expired'
	);

		
		
*/


// Column
$_['column_date_added']         = 'Date Added';
$_['column_type']               = 'Type';
$_['column_amount']             = 'Amount';
$_['column_status']             = 'Status';
$_['column_product']            = 'Product';
$_['column_order_recurring_id'] = 'Recurring ID';

// Error
$_['error_not_cancelled'] = 'Error: %s';
$_['error_not_found']     = 'Could not cancel recurring';

// Button
$_['button_return']       = 'Return';