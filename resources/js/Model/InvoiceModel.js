import invoiceService from "@/Services/InvoiceService.js";

class InvoiceModel {

    setStatus(data) {
        return invoiceService.updateStatus(data)
    }

    createInvoice(data) {
        return invoiceService.createInvoiceMember(data)
    }

    paid(data) {
        return invoiceService.paidInvoice(data)
    }
}

export default new InvoiceModel();
