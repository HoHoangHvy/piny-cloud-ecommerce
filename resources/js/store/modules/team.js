import axios from "axios";

export default {
    namespaced: true,
    state: {
        teams: [], // Stores all teams
        teams_options: [], // Stores all teams
        team: null, // Stores a single team (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_TEAMS(state, teams) {
            state.teams = teams;
        },
        SET_TEAM(state, team) {
            state.team = team;
        },
        ADD_TEAM(state, team) {
            state.teams.push(team);
        },
        UPDATE_TEAM(state, updatedTeam) {
            const index = state.teams.findIndex((team) => team.id === updatedTeam.id);
            if (index !== -1) {
                state.teams.splice(index, 1, updatedTeam);
            }
        },
        DELETE_TEAM(state, teamId) {
            state.teams = state.teams.filter((team) => team.id !== teamId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_TEAMS_OPTIONS(state, teams) {
            state.teams_options = teams;
        }
    },
    actions: {
        async fetchTeamOptions({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/centers/options');
                commit('SET_TEAMS_OPTIONS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching teams:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching teams.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchTeams({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/centers');
                commit('SET_TEAMS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching teams:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching teams.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchTeam({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/centers/${id}`);
                commit('SET_TEAM', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching team:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching team.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createTeam({ commit }, teamData) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/centers', teamData);
                commit('ADD_TEAM', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating team:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating team.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateTeam({ commit }, { id, teamData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/centers/${id}`, teamData);
                commit('UPDATE_TEAM', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating team:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating team.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteTeam({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/centers/${id}`);
                commit('DELETE_TEAM', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting team:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting team.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allTeamsOption: (state) => state.teams_options,
        allTeams: (state) => state.teams,
        singleTeam: (state) => state.team,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
