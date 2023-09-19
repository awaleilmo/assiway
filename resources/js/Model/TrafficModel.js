import trafficService from "@/Services/TrafficService.js";
class TrafficModel {
    trafficBook(book) {
        return trafficService.trafficBook(book);
    }
    statistics() {
        return trafficService.statistics();
    }
}

export default new TrafficModel()
