#!/bin/bash

PLUGIN_SLUG="torro-forms-protectors-plus"

TMP_DIR="${HOME}"/temp
TMP_ORIGIN_DIR="${TMP_DIR}"/"${PLUGIN_SLUG}"-temp
TMP_DEPLOY_DIR="${TMP_DIR}"/"${PLUGIN_SLUG}"

if [ -d "${TMP_ORIGIN_DIR}" ]; then
    rm -rf "${TMP_ORIGIN_DIR}"
fi

if [ -d "${TMP_DEPLOY_DIR}" ]; then
    rm -rf "${TMP_DEPLOY_DIR}"
fi

mkdir -p "${TMP_ORIGIN_DIR}"
mkdir -p "${TMP_DEPLOY_DIR}"

git clone git@github.com:awsmug/torro-forms-protectors-plus.git "${TMP_ORIGIN_DIR}"
cp -r "${TMP_ORIGIN_DIR}"/src/* "${TMP_DEPLOY_DIR}"

cd "${TMP_DEPLOY_DIR}"
composer update --no-dev

cd "${TMP_DIR}"
zip -r "${PLUGIN_SLUG}".zip ./$(basename "${TMP_DEPLOY_DIR}")

rm -rf "${TMP_ORIGIN_DIR}"
rm -rf "${TMP_DEPLOY_DIR}"
