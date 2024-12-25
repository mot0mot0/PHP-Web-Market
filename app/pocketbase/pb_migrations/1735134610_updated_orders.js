/// <reference path="../pb_data/types.d.ts" />
migrate((app) => {
  const collection = app.findCollectionByNameOrId("pbc_3728844674")

  // update collection data
  unmarshal({
    "createRule": "",
    "updateRule": ""
  }, collection)

  return app.save(collection)
}, (app) => {
  const collection = app.findCollectionByNameOrId("pbc_3728844674")

  // update collection data
  unmarshal({
    "createRule": "@collection.users.role != \"buyer\"",
    "updateRule": "@collection.users.role != \"seller\""
  }, collection)

  return app.save(collection)
})
