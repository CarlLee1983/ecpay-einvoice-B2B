<?php

namespace ecPay\eInvoice\Parameter;

class InvoiceTagType
{
    // 發票開立
    const INVOICE = 'I';

    // 發票作廢
    const INVOICE_VOID = 'II';

    // 折讓開立
    const ALLOWANCE = 'A';

    // 折讓作廢
    const ALLOWANCE_VOID = 'AI';

    // 發票中獎
    const INVOICE_WINNING = 'AW';
}
