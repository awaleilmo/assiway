import bookService from "@/Services/BookService.js";
class BookModel {
    setDisplay(data) {
        return bookService.updateDisplay(data)
    }
    setStatus(data) {
        return bookService.updateStatus(data)
    }
}

export default new BookModel()
