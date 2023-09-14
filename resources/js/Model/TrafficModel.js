import trafficService from "@/Services/TrafficService.js";
class TrafficModel {
    trafficBook(book) {
        return trafficService.trafficBook(book);
    }
}

export default new TrafficModel()
