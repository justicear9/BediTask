#!/usr/bin/env bash
# Build PECL imap for the PHP that `php-config` belongs to (Homebrew on Apple Silicon / Intel).
# Run:  bash scripts/install-php-imap-macos.sh
# Or pin PHP 8.3:  PATH="/opt/homebrew/opt/php@8.3/bin:$PATH" bash scripts/install-php-imap-macos.sh
set -euo pipefail

export PATH="/opt/homebrew/bin:/opt/homebrew/sbin:/usr/bin:/bin:/usr/sbin:/sbin"
export PKG_CONFIG_PATH="/opt/homebrew/opt/krb5/lib/pkgconfig${PKG_CONFIG_PATH:+:$PKG_CONFIG_PATH}"
export CPPFLAGS="-I/opt/homebrew/include${CPPFLAGS:+ $CPPFLAGS}"

command -v php-config >/dev/null || {
  echo "php-config not found. Add Homebrew PHP to PATH, e.g.:"
  echo "  export PATH=\"/opt/homebrew/opt/php@8.3/bin:\$PATH\""
  exit 1
}

EXT_DIR="$(php-config --extension-dir)"
API_VER="$(basename "$EXT_DIR")"
PECL_ROOT="/opt/homebrew/lib/php/pecl"
mkdir -p "$PECL_ROOT/$API_VER"

brew list imap-uw &>/dev/null || brew install imap-uw
brew list krb5 &>/dev/null || brew install krb5
brew list pkgconf &>/dev/null || brew install pkgconf

WORKDIR="$(mktemp -d "${TMPDIR:-/tmp}/imap-pecl.XXXXXX")"
trap 'rm -rf "$WORKDIR"' EXIT
cd "$WORKDIR"

pecl download imap-1.0.3
tar xzf imap-1.0.3.tgz
cd imap-1.0.3

phpize
./configure \
  --with-php-config="$(command -v php-config)" \
  --with-imap=/opt/homebrew \
  --with-imap-ssl=/opt/homebrew/opt/openssl@3 \
  --with-kerberos

make -j"$(sysctl -n hw.ncpu 2>/dev/null || echo 4)"
make install

PHP_VER="$(php-config --version | cut -d. -f1,2)"
INI_DIR="/opt/homebrew/etc/php/${PHP_VER}/conf.d"
if [[ -d "$INI_DIR" ]]; then
  echo "extension=imap" > "${INI_DIR}/ext-imap.ini"
  echo "Wrote ${INI_DIR}/ext-imap.ini"
else
  echo "No conf.d at $INI_DIR — add this line to php.ini:"
  echo "  extension=imap"
fi

php -m | grep -i '^imap$' && echo "IMAP extension loaded OK."
