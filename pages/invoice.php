<?php
    $db_handle = new DBController();
    $conn = $db_handle->connection();
//    $query = 'SELECT *, franchise.name AS franchise_name, users.name AS case_name FROM
//                student_case AS a1 LEFT JOIN franchise ON a1.franchise=franchise.id
//                LEFT JOIN users ON a1.case_generated_by = users.id   WHERE a1.id='.$_GET['student'];
    $query ='SELECT a1.id,a1.name,a1.email,a1.phone,a1.cnic, franchise.name as franchise_name , users.name as case_name FROM student_case as a1 left join franchise ON a1.franchise=franchise.id left join users ON a1.case_generated_by = users.id WHERE a1.id='.$_GET['student'];
    $studentCases = $conn->query($query);
   // print_r($studentCases);
    $query = 'SELECT * FROM `fee` WHERE `id`='.$_GET['fee'];
    $fee = $conn->query($query);
    if (empty($_GET['student']) || ($studentCases->num_rows==0) || empty($_GET['fee']) || ($fee->num_rows==0) ):
       // echo "<script>window.location='404';</script>";
    endif;
    $fee = $fee->fetch_assoc();
    $studentCase = $studentCases->fetch_assoc();
    //print_r($studentCase);
?>
<style>
    @media print {
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 1.6cm;
        }
        .fixed-navbar{
            display:none;
        }
        .no-print{
            display:none;
        }
    }
    ul{
        padding: 0;
        list-style: none;
        /*border-bottom: 1px solid silver;*/
    }
    body{
        font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
        margin: 0;
    }
    .container{
        padding: 20px 40px;
    }
    .inv-header{
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .inv-header :nth-child(2){
        flex-basis: 30%;
    }
    .inv-title{
        padding: 10px;
        border: 1px solid silver;
        text-align: center;
        margin-bottom: 20px;
    }
    .no-margin{
        margin: 0;
    }
    .inv-logo{
        width: 300px;
    }
    .inv-header h2{
        font-size: 20px;
        margin: 1rem 0 0 0;
    }
    .inv-header ul li{
        font-size: 15px;
        padding: 3px 0;
    }

    /* table in head */
    .inv-header table{
        width: 100%;
        border-collapse: collapse;
    }
    .inv-header table th, .inv-header table td, .inv-header table{
        border: 1px solid silver;
    }
    .inv-header table th, .inv-header table td{
        text-align: right;
        padding: 8px;
    }

    /* Body */
    .inv-body{
        margin-bottom: 20px;
    }
    .inv-body table{
        width: 100%;
        border: 1px solid silver;
        border-collapse: collapse;
    }
    .inv-body table th, .inv-body table td{
        padding: 10px;
        border: 1px solid silver;
    }
    .inv-body table td h5, .inv-body table td p{
        margin: 0 5px 0 0;
    }
    /* Footer */
    .inv-footer{
        clear: both;
        overflow: auto;
    }
    .inv-footer table{
        width: 30%;
        float: right;
        border: 1px solid silver;
        border-collapse: collapse;
    }
    .inv-footer table th, .inv-footer table td{
        padding: 8px;
        text-align: right;
        border: 1px solid silver;
    }
</style>
<div class="container">
    <div class="inv-title">
        <h2 class="no-margin">INV-PARAGON-<?=str_pad($fee['id'], 4, '0', STR_PAD_LEFT);?></h2>
    </div>
    <div class="inv-header">
        <div>
            <img src="assets/images/logo.png" class="inv-logo">
            <ul style="padding-left:10px">
                <li>3-C GCP Shokat Khanum Chowk.</li>
                <li>Lahore. Pakistan 54000</li>
                <li>(042) 35774803 | info@paragonconsultants.pk</li>
                <li>Franchise : <?=$studentCase['franchise_name']?></li>
                <li>Consultants : <?=$studentCase['case_name']?></li>
            </ul>

        </div>
        <div>

        </div>
        <div>
            <table>
                <tr>
                    <th>Issue Date</th>
                    <td><?=$fee['created_at']?></td>
                </tr>
                <tr>
                    <th>Due Date</th>
                    <td><?=date('Y-m-d', strtotime($fee['created_at']. ' + 5 day'))?></td>
                </tr>
                <tr>
                    <th>Sub total</th>
                    <td><?=$fee['fee_amount']?></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td><?=$fee['fee_amount']?></td>
                </tr>
            </table>
            <br>
            <h2><?=$studentCase['name']?></h2>
            <ul>
                <li><?=$studentCase['cnic']?></li>
                <li><?=$studentCase['phone']?></li>
                <li><?=$studentCase['email']?></li>
            </ul>

        </div>
    </div>
    <div class="inv-body">
        <table>
            <thead>
            <th>Fee</th>
            <th>Fee Amount</th>
            <th>Fee Type</th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <h5><b><?=$fee['fees']?></b></h5>
                </td>
                <td><?=$fee['fee_amount']?></td>
                <td>2000</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="inv-footer">
        <table>
            <tr>
                <th>Sub total</th>
                <td><?=$fee['fee_amount']?></td>
            </tr>
            <tr>
                <th>Sales tax</th>
                <td>0</td>
            </tr>
            <tr>
                <th>Grand total</th>
                <td><?=$fee['fee_amount']?></td>
            </tr>
        </table>
    </div>
</div>
<a href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$studentCase['id']?>" class="btn btn-info no-print"><i class="fas fa-arrow-left "></i></a>
<button id="printInvoice" class="btn btn-info no-print"><i class="fa fa-print"></i> Print</button>
<script type="text/javascript">
    document.getElementById('printInvoice').addEventListener('click', function(){
        window.print();
    });
</script>
