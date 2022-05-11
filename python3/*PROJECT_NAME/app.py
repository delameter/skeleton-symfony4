# -----------------------------------------------------------------------------
# *PROJECT_NAME [*PROJECT_DESCRIPTION]
# (C) 2022 A. Shavykin <0.delameter@gmail.com>
# -----------------------------------------------------------------------------

# noinspection PyMethodMayBeStatic
class App:
    def run(self):
        try:
            self._parse_args()
            # runner_run()
        except Exception as e:
            # on_exception(e)
            self._exit(1)
        self._exit(0)

    def _parse_args(self):
        pass

    def _exit(self, code: int):
        print()
        exit(code)
