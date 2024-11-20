#!/bin/bash
# Install CodeDeploy agent
yum install -y ruby
yum install -y wget

# Install the CodeDeploy agent from the Amazon repository
yum install -y codedeploy-agent

# Ensure the agent is running
systemctl enable codedeploy-agent
systemctl start codedeploy-agent
