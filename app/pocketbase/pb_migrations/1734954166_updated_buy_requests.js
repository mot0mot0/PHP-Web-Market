/// <reference path="../pb_data/types.d.ts" />
migrate((app) => {
  const collection = app.findCollectionByNameOrId("pbc_3728844674")

  // update collection data
  unmarshal({
    "name": "orders"
  }, collection)

  return app.save(collection)
}, (app) => {
  const collection = app.findCollectionByNameOrId("pbc_3728844674")

  // update collection data
  unmarshal({
    "name": "buy_requests"
  }, collection)

  return app.save(collection)
})
