
# TARGETS
default:
	@echo "Need a target. Pick one of these:"
	@# list the available targets (this cheats a bit)
	@grep '^[a-z]' Makefile | sed 's/:.*$$//' | sort
