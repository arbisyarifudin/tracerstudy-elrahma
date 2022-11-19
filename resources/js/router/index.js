import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes.js'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

/**
 * A stack of different middlewares ran in series
 * Link: https://blog.logrocket.com/vue-middleware-pipelines/
 */
function middlewarePipeline(context, middlewares, index) {
  const middleware = middlewares[index]
  if (!middleware) return context.next
  return () => {
    const nextMiddleware = middlewarePipeline(context, middlewares, index + 1)
    middleware({ ...context, next: nextMiddleware })
  }
}

/**
 * Run the middleware(s) using the beforeEach hook
 */
router.beforeEach((to, from, next) => {
  if (!to.meta.middlewares) return next()
  const middlewares = to.meta.middlewares
  const context = { to, from, next, router }
  return middlewares[0]({
    ...context,
    next: middlewarePipeline(context, middlewares, 1)
  })
})

export default router
