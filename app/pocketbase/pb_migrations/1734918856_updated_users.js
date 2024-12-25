/// <reference path="../pb_data/types.d.ts" />
migrate((app) => {
  const collection = app.findCollectionByNameOrId("pbc_3754236674")

  // update collection data
  unmarshal({
    "name": "_users"
  }, collection)

  return app.save(collection)
}, (app) => {
  const collection = app.findCollectionByNameOrId("pbc_3754236674")

  // update collection data
  unmarshal({
    "name": "users"
  }, collection)

  return app.save(collection)
})
