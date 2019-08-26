<?php
        $idno = $_POST['idno'];


          $conn = oci_connect('vdc_p_rpt', 'vdc_p_rpt', ' 10.128.0.23:1521/orcl ');
          if (!$conn) 
          {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
          }
            $stmt = oci_parse($conn, " select sum(d.NOT_SETTLE/100)+(sum(d.CSH_ADVNC)+sum(d.PAYMENT))+(sum(d.BNK_CHRG)+sum(d.POS_PRCHS)) as Total_OS,
                (sum(d.CSH_ADVNC)+sum(d.PAYMENT))+(sum(d.BNK_CHRG)+sum(d.POS_PRCHS)) as Bill_Amnt,
                (sum(d.S_CSH_ADVNC)+sum(d.S_PAYMENT))+(sum(d.S_BNK_CHRG)+sum(d.S_POS_PRCHS)) as Hold_Amnt,
                (sum(d.BONUS_LMT)+sum(d.CARD_LIMIT)) as Card_Limit
                from 
                (SELECT BALANCE_TYPE,TOTAL_OUTSTANDING,NOT_SETTLE,
                case when BALANCE_TYPE = 'BNK_CHRG' then TOTAL_OUTSTANDING/100 end BNK_CHRG,
                case when BALANCE_TYPE = 'BONUS_LMT' then TOTAL_OUTSTANDING/100 end BONUS_LMT,
                case when BALANCE_TYPE = 'CARD_LIMIT' then TOTAL_OUTSTANDING/100 end CARD_LIMIT,
                case when BALANCE_TYPE = 'CSH_ADVNC' then TOTAL_OUTSTANDING/100 end CSH_ADVNC,
                case when BALANCE_TYPE = 'PAYMENT' then TOTAL_OUTSTANDING/100 end PAYMENT,
                case when BALANCE_TYPE = 'POS_PRCHS' then TOTAL_OUTSTANDING/100 end POS_PRCHS,

                case when BALANCE_TYPE = 'BNK_CHRG' then NOT_SETTLE/100 end S_BNK_CHRG,
                case when BALANCE_TYPE = 'CSH_ADVNC' then NOT_SETTLE/100 end S_CSH_ADVNC,
                case when BALANCE_TYPE = 'PAYMENT' then NOT_SETTLE/100 end S_PAYMENT,
                case when BALANCE_TYPE = 'POS_PRCHS' then NOT_SETTLE/100 end S_POS_PRCHS
                FROM VDC_P_BKN.BKN_DM_ACCT_BAL
                WHERE ACCOUNT_SERIAL_NUMBER = (select distinct a.account_serial_number from VDC_P_BKN.BKN_DM_ACCT_BAL a
                left join vdc_p_bkn.bkn_dm_acct b on a.account_serial_number = b.account_serial_number
                left join vdc_p_crd.CRD_DL_CRD_ACCT c on b.account_number = c.account_no
                where c.card_no = '$idno')
                and balance_type in ('BNK_CHRG','BONUS_LMT','CARD_LIMIT','CSH_ADVNC','PAYMENT','POS_PRCHS'))d "); 
            oci_execute($stmt);



            while(($row=oci_fetch_array($stmt,OCI_ASSOC+OCI_RETURN_LOBS))!=false)
            { 

                 // $TOTAL_OS= $row['TOTAL_OS']."<br/>";
                 // $BILL_AMNT= $row['BILL_AMNT']."<br/>"; 
                 // $HOLD_AMNT= $row['HOLD_AMNT']."<br/>";
                 // $CARD_LIMIT= $row['CARD_LIMIT']."<br/>";

                  echo 'Total Amount: <input type="text" value="'.$row['TOTAL_OS'].'"> <br>';
                  echo 'Bill Amount: <input type="text" value="'.$row['BILL_AMNT'].'"> <br>';
                  echo 'Hold Amount: <input type="text" value="'.$row['HOLD_AMNT'].'"> <br>';
                  echo 'Card LImit: <input type="text" value="'.$row['CARD_LIMIT'].'">';
            
            }
            oci_free_statement($stmt);
            oci_close($conn); 
        ?>