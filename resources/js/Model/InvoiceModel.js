import invoiceService from "@/Services/InvoiceService.js";

class InvoiceModel {
    setStatus(data) {
        return invoiceService.updateStatus(data)
    }
}

export default new InvoiceModel();
