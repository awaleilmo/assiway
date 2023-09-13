import bookService from "@/Services/BookService.js";
class BookModel {
    setDisplay(data) {
        return bookService.updateDisplay(data)
    }
    setStatus(data) {
        return bookService.updateStatus(data)
    }

    checkIsMyBook(data) {
        return bookService.checkIsMyBook(data)
    }
}

export default new BookModel()
