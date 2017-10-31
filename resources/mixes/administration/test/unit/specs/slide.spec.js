// import Vue from 'vue'
import Slide from '../../../src/pages/Slide.vue'

describe('Slide', () => {
    it('sets the correct default data', () => {
        expect(typeof Slide.data).toBe('function')
        const defaultData = Slide.data()
        expect(defaultData.page.total).toBe(0)
    })
})