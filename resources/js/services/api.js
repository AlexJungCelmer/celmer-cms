import axios from "axios";
import Vuex from "../store/index"
import Vue from "./vueService"

export default class Api {
	constructor(token) {
		// servidor teste do postman
		this.axiosService = axios.create({
			baseURL: "/api/",
			headers: { "Authorization": token }
		});
		this.axiosService.interceptors.response.use(
			(response) => {
				return response;
			},
			(error) => {
				Vue.$emit(error.response.status, error.response);
				return error;
			}
		);
	}

	static new() {
		let api = new Api(Vuex.state.user.token);
		return api;
	}

	async getEntries(app, collection){
		return this.axiosService('apps/'+app+'/collections/'+collection+'/entries')
	}

}