import axios from "axios";

export default {
    namespaced: true,
    state: {
        employees: [], // Stores all employees
        employee: null, // Stores a single employee (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_EMPLOYEES(state, employees) {
            state.employees = employees;
        },
        SET_EMPLOYEE(state, employee) {
            state.employee = employee;
        },
        ADD_EMPLOYEE(state, employee) {
            state.employees.push(employee);
        },
        UPDATE_EMPLOYEE(state, updatedEmployee) {
            const index = state.employees.findIndex((emp) => emp.id === updatedEmployee.id);
            if (index !== -1) {
                state.employees.splice(index, 1, updatedEmployee);
            }
        },
        DELETE_EMPLOYEE(state, employeeId) {
            state.employees = state.employees.filter((emp) => emp.id !== employeeId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchEmployees({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/employees');

                commit('SET_EMPLOYEES', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching employees:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching employees.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchEmployee({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/employees/${id}`);
                commit('SET_EMPLOYEE', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching employee:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching employee.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createEmployee({ commit }, employeeData) {
            commit('SET_LOADING', true);
            try {

                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/employees', employeeData);
                commit('ADD_EMPLOYEE', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating employee:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating employee.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateEmployee({ commit }, { id, employeeData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/employees/${id}`, employeeData);
                commit('UPDATE_EMPLOYEE', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating employee:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating employee.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteEmployee({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/employees/${id}`);
                commit('DELETE_EMPLOYEE', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting employee:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting employee.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allEmployees: (state) => state.employees,
        singleEmployee: (state) => state.employee,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
